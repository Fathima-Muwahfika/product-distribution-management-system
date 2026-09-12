<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function stock()
    {
        $products = Product::orderBy('category')->get();
        $totalProducts   = $products->count();
        $lowStockCount   = $products->filter(fn($p) => $p->stock_qty <= $p->min_stock_level)->count();
        $localCount      = $products->where('source', 'Local')->count();
        $importCount     = $products->where('source', 'Import')->count();
        return view('reports.stock', compact('products', 'totalProducts', 'lowStockCount', 'localCount', 'importCount'));
    }

    public function orders(Request $request)
    {
        $query = Order::with('shop', 'user');
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('order_date', [$request->from_date, $request->to_date]);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $orders      = $query->latest()->get();
        $totalAmount = $orders->sum('total_amount');
        return view('reports.orders', compact('orders', 'totalAmount'));
    }

    public function payments(Request $request)
    {
        $query = Invoice::with('shop');
        if ($request->status) {
            $query->where('payment_status', $request->status);
        }
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('invoice_date', [$request->from_date, $request->to_date]);
        }
        $invoices    = $query->latest()->get();
        $totalPaid   = Invoice::where('payment_status', 'Paid')->sum('total_amount');
        $totalUnpaid = Invoice::where('payment_status', 'Unpaid')->sum('total_amount');
        return view('reports.payments', compact('invoices', 'totalPaid', 'totalUnpaid'));
    }

    public function deliveries(Request $request)
    {
        $query = Delivery::with('order.shop');
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $deliveries      = $query->latest()->get();
        $totalDeliveries = $deliveries->count();
        $delivered       = $deliveries->where('status', 'Delivered')->count();
        $pending         = $deliveries->where('status', 'Pending')->count();
        $outForDelivery  = $deliveries->where('status', 'Out for Delivery')->count();
        return view('reports.deliveries', compact('deliveries', 'totalDeliveries', 'delivered', 'pending', 'outForDelivery'));
    }

    public function salesRep(Request $request)
    {
        $reps = User::where('role', 'salesrep')
            ->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->get();
        return view('reports.salesrep', compact('reps'));
    }
}