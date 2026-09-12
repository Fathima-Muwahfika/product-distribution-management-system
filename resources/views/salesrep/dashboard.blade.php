@extends('layouts.salesrep')
@section('page-title', 'My Dashboard')

@section('content')

<!-- Welcome Bar -->
<div class="welcome-bar mb-4">
    <div>
        <div class="welcome-title">
            {{ date('H') < 12 ? 'Good Morning' : (date('H') < 17 ? 'Good Afternoon' : 'Good Evening') }}, {{ Auth::user()->name }}! 👋
        </div>
        <div class="welcome-sub">කැදැල්ල Distributors · {{ date('l, d F Y') }}</div>
    </div>
    <a href="{{ route('salesrep.orders.create') }}" class="new-order-btn">
        <i class="fas fa-plus me-2"></i> New Order
    </a>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <a href="{{ route('salesrep.orders') }}" class="stat-link">
            <div class="stat-card">
                <div class="stat-card-inner">
                    <div>
                        <div class="stat-label">My Total Orders</div>
                        <div class="stat-value">{{ $myOrders }}</div>
                        <div class="stat-sub">All time</div>
                    </div>
                    <div class="stat-icon blue">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('salesrep.orders') }}" class="stat-link">
            <div class="stat-card">
                <div class="stat-card-inner">
                    <div>
                        <div class="stat-label">Pending Orders</div>
                        <div class="stat-value text-warning">{{ $myPendingOrders }}</div>
                        <div class="stat-sub">Awaiting processing</div>
                    </div>
                    <div class="stat-icon orange">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('salesrep.orders') }}" class="stat-link">
            <div class="stat-card">
                <div class="stat-card-inner">
                    <div>
                        <div class="stat-label">Delivered</div>
                        <div class="stat-value text-success">{{ $myDelivered }}</div>
                        <div class="stat-sub">Completed orders</div>
                    </div>
                    <div class="stat-icon green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div>
                    <div class="stat-label">This Month</div>
                    <div class="stat-value">{{ $myOrdersThisMonth }}</div>
                    <div class="stat-sub">Orders created</div>
                </div>
                <div class="stat-icon purple">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <a href="{{ route('salesrep.products') }}" class="stat-link">
            <div class="stat-card">
                <div class="stat-card-inner">
                    <div>
                        <div class="stat-label">Products Available</div>
                        <div class="stat-value">{{ $totalProducts }}</div>
                        <div class="stat-sub">In catalog</div>
                    </div>
                    <div class="stat-icon blue">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('salesrep.shops') }}" class="stat-link">
            <div class="stat-card">
                <div class="stat-card-inner">
                    <div>
                        <div class="stat-label">Available Shops</div>
                        <div class="stat-value text-success">{{ $totalShops }}</div>
                        <div class="stat-sub">Active shops</div>
                    </div>
                    <div class="stat-icon green">
                        <i class="fas fa-store"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Quick Actions -->
<div class="card mb-3">
    <div class="card-header-clean">
        <div class="card-header-title">
            <i class="fas fa-bolt me-2" style="color:#f0c040;"></i>Quick Actions
        </div>
    </div>
    <div class="card-body">
        <div class="row g-2">
            <div class="col">
                <a href="{{ route('salesrep.orders.create') }}" class="quick-btn primary">
                    <i class="fas fa-plus-circle"></i>
                    <span>New Order</span>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('salesrep.orders') }}" class="quick-btn">
                    <i class="fas fa-clipboard-list"></i>
                    <span>My Orders</span>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('salesrep.shops') }}" class="quick-btn">
                    <i class="fas fa-store"></i>
                    <span>Shops</span>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('salesrep.shops.create') }}" class="quick-btn">
                    <i class="fas fa-plus"></i>
                    <span>Add Shop</span>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('salesrep.products') }}" class="quick-btn">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('salesrep.deliveries') }}" class="quick-btn">
                    <i class="fas fa-truck"></i>
                    <span>Deliveries</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="row g-3">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header-clean d-flex justify-content-between align-items-center">
                <div class="card-header-title">
                    <i class="fas fa-clipboard-list me-2"></i>My Recent Orders
                </div>
                <a href="{{ route('salesrep.orders') }}" class="view-all-link">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Shop</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->shop->shop_name }}</td>
                            <td>LKR {{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                @if($order->status == 'Pending')
                                    <span class="dash-badge yellow">Pending</span>
                                @elseif($order->status == 'Delivered')
                                    <span class="dash-badge green">Delivered</span>
                                @elseif($order->status == 'Out for Delivery')
                                    <span class="dash-badge blue">On Route</span>
                                @else
                                    <span class="dash-badge gray">{{ $order->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">
                                No orders yet.
                                <a href="{{ route('salesrep.orders.create') }}">Create one!</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header-clean">
                <div class="card-header-title">
                    <i class="fas fa-exclamation-triangle me-2" style="color:#e74c3c;"></i>Low Stock Warning
                </div>
            </div>
            <div class="card-body p-0">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockItems as $item)
                        <tr>
                            <td style="font-size:12px;">{{ $item->name }}</td>
                            <td><span class="dash-badge red">{{ $item->stock_qty }} left</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted py-3">
                                <i class="fas fa-check-circle text-success me-1"></i>All stock OK!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<style>
    .welcome-bar { background:white; border-radius:12px; padding:16px 22px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 1px 6px rgba(0,0,0,0.06); border:1px solid #f1f5f9; }
    .welcome-title { font-size:16px; font-weight:700; color:#0f2744; }
    .welcome-sub { font-size:12px; color:#94a3b8; margin-top:2px; }
    .new-order-btn { background:linear-gradient(135deg,#0f2744,#2d6a9f); color:white; padding:9px 18px; border-radius:10px; text-decoration:none; font-size:13px; font-weight:600; display:flex; align-items:center; transition:all 0.2s; }
    .new-order-btn:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(45,106,159,0.3); color:white; }

    .stat-link { text-decoration:none; display:block; }
    .stat-card { background:white; border-radius:12px; padding:16px 18px; box-shadow:0 1px 6px rgba(0,0,0,0.06); border:1px solid #f1f5f9; transition:all 0.2s; }
    .stat-card:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(0,0,0,0.1); }
    .stat-card-inner { display:flex; justify-content:space-between; align-items:center; }
    .stat-label { font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px; }
    .stat-value { font-size:26px; font-weight:700; color:#0f2744; line-height:1; margin-bottom:4px; }
    .stat-sub { font-size:11px; color:#b0bec8; }
    .stat-icon { width:44px; height:44px; border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
    .stat-icon.blue { background:#e8f0fb; color:#2d6a9f; }
    .stat-icon.red { background:#fff5f5; color:#e74c3c; }
    .stat-icon.green { background:#eafaf1; color:#27ae60; }
    .stat-icon.orange { background:#fef9e7; color:#e67e22; }
    .stat-icon.purple { background:#f5eef8; color:#9b59b6; }

    .card { border:1px solid #f1f5f9; border-radius:12px; box-shadow:0 1px 6px rgba(0,0,0,0.05); }
    .card-header-clean { padding:14px 18px 10px; border-bottom:1px solid #f8fafc; }
    .card-header-title { font-size:13px; font-weight:600; color:#0f2744; display:flex; align-items:center; }
    .card-header-title i { color:#2d6a9f; }
    .view-all-link { font-size:11px; color:#2d6a9f; text-decoration:none; font-weight:600; }

    .quick-btn { display:flex; flex-direction:column; align-items:center; gap:7px; padding:12px 8px; border-radius:10px; border:1px solid #f1f5f9; text-decoration:none; transition:all 0.2s; background:white; color:#0f2744; font-size:11px; font-weight:600; text-align:center; }
    .quick-btn i { font-size:18px; color:#2d6a9f; }
    .quick-btn:hover { border-color:#2d6a9f; background:#f0f6ff; color:#0f2744; transform:translateY(-2px); }
    .quick-btn.primary { background:linear-gradient(135deg,#0f2744,#2d6a9f); color:white; border-color:transparent; }
    .quick-btn.primary i { color:white; }
    .quick-btn.primary:hover { opacity:0.9; color:white; }

    .dash-table { width:100%; border-collapse:collapse; }
    .dash-table thead tr { background:#fafbfc; }
    .dash-table thead th { padding:10px 16px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px; border-bottom:1px solid #f1f5f9; }
    .dash-table tbody td { padding:10px 16px; font-size:12px; color:#334155; border-bottom:1px solid #f8fafc; vertical-align:middle; }
    .dash-table tbody tr:last-child td { border-bottom:none; }
    .dash-table tbody tr:hover td { background:#fafbfd; }

    .dash-badge { padding:3px 9px; border-radius:6px; font-size:10px; font-weight:600; }
    .dash-badge.green { background:#eafaf1; color:#27ae60; }
    .dash-badge.yellow { background:#fef9e7; color:#d4930a; }
    .dash-badge.blue { background:#e8f4fd; color:#2d6a9f; }
    .dash-badge.red { background:#fff5f5; color:#e74c3c; }
    .dash-badge.gray { background:#f1f5f9; color:#64748b; }

    .text-success { color:#27ae60 !important; }
    .text-danger { color:#e74c3c !important; }
    .text-warning { color:#d4930a !important; }
    .text-muted { color:#94a3b8 !important; font-size:11px; }
</style>
@endsection