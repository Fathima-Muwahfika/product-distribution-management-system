<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Delivery;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\SystemNotification;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Stat Cards ──
        $totalProducts     = Product::count();
        $lowStockProducts  = Product::whereColumn('stock_qty', '<=', 'min_stock_level')->count();
        $totalShops        = Shop::count();
        $totalOrders       = Order::count();
        $pendingOrders     = Order::where('status', 'Pending')->count();
        $pendingDeliveries = Delivery::where('status', 'Out for Delivery')->count();
        $unpaidInvoices    = Invoice::where('payment_status', 'Unpaid')->count();
        $totalRevenue      = Invoice::where('payment_status', 'Paid')->sum('total_amount');
        $totalSalesReps    = User::where('role', 'salesrep')->where('status', 'Active')->count();

        // ── Recent Orders ──
        $recentOrders  = Order::with('shop', 'user')->latest()->take(6)->get();

        // ── Low Stock Items ──
        $lowStockItems = Product::whereColumn('stock_qty', '<=', 'min_stock_level')->take(6)->get();

        // ── Daily Orders Chart (last 7 days) ──
        $dailyOrders = [];
        $dailyLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyLabels[] = $date->format('D d');
            $dailyOrders[] = Order::whereDate('created_at', $date)->count();
        }

        // ── Monthly Revenue Chart (last 6 months) ──
        $monthlyRevenue = [];
        $monthlyLabels  = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyLabels[]  = $date->format('M Y');
            $monthlyRevenue[] = Invoice::where('payment_status', 'Paid')
                ->whereYear('invoice_date', $date->year)
                ->whereMonth('invoice_date', $date->month)
                ->sum('total_amount');
        }

        // ── Top 5 Selling Products ──
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();
        $topProductLabels = $topProducts->pluck('name')->toArray();
        $topProductData   = $topProducts->pluck('total_sold')->toArray();

        // ── Payment Status (Pie Chart) ──
        $paidCount   = Invoice::where('payment_status', 'Paid')->count();
        $unpaidCount = Invoice::where('payment_status', 'Unpaid')->count();

        // ── Orders by Sales Rep ──
        $repOrders = User::where('role', 'salesrep')
            ->withCount('orders')
            ->orderByDesc('orders_count')
            ->take(5)
            ->get();
        $repLabels = $repOrders->pluck('name')->toArray();
        $repData   = $repOrders->pluck('orders_count')->toArray();

        // ── Notifications ──
        $notifications     = SystemNotification::where('is_read', false)->latest()->take(5)->get();
        $notificationCount = SystemNotification::where('is_read', false)->count();

        // ── Activity Log ──
        $recentActivities = ActivityLog::with('user')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalProducts', 'lowStockProducts', 'totalShops', 'totalOrders',
            'pendingOrders', 'pendingDeliveries', 'unpaidInvoices', 'totalRevenue',
            'totalSalesReps', 'recentOrders', 'lowStockItems',
            'dailyOrders', 'dailyLabels',
            'monthlyRevenue', 'monthlyLabels',
            'topProductLabels', 'topProductData',
            'paidCount', 'unpaidCount',
            'repLabels', 'repData',
            'notifications', 'notificationCount',
            'recentActivities'
        ));
    }

    public function activityLog()
    {
        $activities = ActivityLog::with('user')->latest()->paginate(20);
        return view('activity', compact('activities'));
    }
}