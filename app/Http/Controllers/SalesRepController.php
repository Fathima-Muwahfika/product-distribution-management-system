<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Delivery;
use Illuminate\Support\Facades\Auth;

class SalesRepController extends Controller
{
    public function dashboard()
    {
        $myOrders        = Order::where('user_id', Auth::id())->count();
        $myPendingOrders = Order::where('user_id', Auth::id())
                                ->where('status', 'Pending')->count();
        $myDelivered     = Order::where('user_id', Auth::id())
                                ->where('status', 'Delivered')->count();
        $totalProducts   = Product::count();
        $totalShops      = Shop::count();
        $lowStockItems   = Product::whereColumn('stock_qty', '<=', 'min_stock_level')
                                  ->take(5)->get();
        $recentOrders    = Order::where('user_id', Auth::id())
                                ->with('shop')
                                ->latest()
                                ->take(5)
                                ->get();
        $myOrdersThisMonth = Order::where('user_id', Auth::id())
                                  ->whereMonth('created_at', now()->month)
                                  ->count();

        return view('salesrep.dashboard', compact(
            'myOrders',
            'myPendingOrders',
            'myDelivered',
            'totalProducts',
            'totalShops',
            'lowStockItems',
            'recentOrders',
            'myOrdersThisMonth'
        ));
    }
}