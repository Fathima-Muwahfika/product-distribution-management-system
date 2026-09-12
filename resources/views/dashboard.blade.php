@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('content')

<!-- Welcome Bar -->
<div class="welcome-bar mb-4">
    <div>
        <div class="welcome-title">
            {{ date('H') < 12 ? 'Good Morning' : (date('H') < 17 ? 'Good Afternoon' : 'Good Evening') }}, {{ Auth::user()->name }}! 👋
        </div>
        <div class="welcome-sub">කැදැල්ල Distributors · {{ date('l, d F Y') }}</div>
    </div>
    <div class="welcome-badge">
        <span class="status-dot"></span> System Online
    </div>
</div>

<!-- Stat Cards Row 1 -->
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <a href="{{ route('products.index') }}" class="stat-link">
            <div class="stat-card">
                <div class="stat-card-inner">
                    <div>
                        <div class="stat-label">Total Products</div>
                        <div class="stat-value">{{ $totalProducts }}</div>
                        <div class="stat-sub">In inventory</div>
                    </div>
                    <div class="stat-icon blue">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('products.index') }}?stock_status=low" class="stat-link">
            <div class="stat-card">
                <div class="stat-card-inner">
                    <div>
                        <div class="stat-label">Low Stock</div>
                        <div class="stat-value text-danger">{{ $lowStockProducts }}</div>
                        <div class="stat-sub">Need restocking</div>
                    </div>
                    <div class="stat-icon red">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('shops.index') }}" class="stat-link">
            <div class="stat-card">
                <div class="stat-card-inner">
                    <div>
                        <div class="stat-label">Total Shops</div>
                        <div class="stat-value text-success">{{ $totalShops }}</div>
                        <div class="stat-sub">Registered shops</div>
                    </div>
                    <div class="stat-icon green">
                        <i class="fas fa-store"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('orders.index') }}" class="stat-link">
            <div class="stat-card">
                <div class="stat-card-inner">
                    <div>
                        <div class="stat-label">Total Orders</div>
                        <div class="stat-value text-warning">{{ $totalOrders }}</div>
                        <div class="stat-sub">All time</div>
                    </div>
                    <div class="stat-icon orange">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Stat Cards Row 2 -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <a href="{{ route('orders.index') }}?status=Pending" class="stat-link">
            <div class="stat-card">
                <div class="stat-card-inner">
                    <div>
                        <div class="stat-label">Pending Orders</div>
                        <div class="stat-value">{{ $pendingOrders }}</div>
                        <div class="stat-sub">Awaiting processing</div>
                    </div>
                    <div class="stat-icon purple">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('deliveries.index') }}" class="stat-link">
            <div class="stat-card">
                <div class="stat-card-inner">
                    <div>
                        <div class="stat-label">Active Deliveries</div>
                        <div class="stat-value">{{ $pendingDeliveries }}</div>
                        <div class="stat-sub">Out for delivery</div>
                    </div>
                    <div class="stat-icon teal">
                        <i class="fas fa-truck"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('invoices.index') }}" class="stat-link">
            <div class="stat-card">
                <div class="stat-card-inner">
                    <div>
                        <div class="stat-label">Unpaid Invoices</div>
                        <div class="stat-value text-danger">{{ $unpaidInvoices }}</div>
                        <div class="stat-sub">Outstanding payments</div>
                    </div>
                    <div class="stat-icon red">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('users.index') }}" class="stat-link">
            <div class="stat-card">
                <div class="stat-card-inner">
                    <div>
                        <div class="stat-label">Sales Reps</div>
                        <div class="stat-value text-success">{{ $totalSalesReps }}</div>
                        <div class="stat-sub">Active members</div>
                    </div>
                    <div class="stat-icon blue">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Revenue Banner -->
<div class="revenue-banner mb-4">
    <div class="revenue-banner-left">
        <div class="revenue-banner-icon">
            <i class="fas fa-coins"></i>
        </div>
        <div>
            <div class="revenue-banner-label">Total Revenue Collected</div>
            <div class="revenue-banner-value">LKR {{ number_format($totalRevenue, 2) }}</div>
        </div>
    </div>
    <div class="revenue-banner-right">
        <div class="revenue-meta-item">
            <div class="revenue-meta-value">{{ $paidCount }}</div>
            <div class="revenue-meta-label">Paid Invoices</div>
        </div>
        <div class="revenue-meta-divider"></div>
        <div class="revenue-meta-item">
            <div class="revenue-meta-value text-danger">{{ $unpaidCount }}</div>
            <div class="revenue-meta-label">Unpaid Invoices</div>
        </div>
        <div class="revenue-meta-divider"></div>
        <div class="revenue-meta-item">
            <div class="revenue-meta-value">{{ $totalSalesReps }}</div>
            <div class="revenue-meta-label">Sales Reps</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-3 mb-3">
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header-clean">
                <div class="card-header-title">
                    <i class="fas fa-chart-bar me-2"></i>Daily Orders
                </div>
                <div class="card-header-sub">Last 7 days</div>
            </div>
            <div class="card-body pt-2">
                <canvas id="dailyOrdersChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header-clean">
                <div class="card-header-title">
                    <i class="fas fa-chart-pie me-2"></i>Payment Status
                </div>
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <canvas id="paymentPieChart" style="max-height:160px;"></canvas>
                <div class="pie-legend mt-3">
                    <div class="pie-legend-item">
                        <span class="pie-dot" style="background:#27ae60;"></span>
                        Paid ({{ $paidCount }})
                    </div>
                    <div class="pie-legend-item">
                        <span class="pie-dot" style="background:#e74c3c;"></span>
                        Unpaid ({{ $unpaidCount }})
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header-clean">
                <div class="card-header-title">
                    <i class="fas fa-chart-line me-2"></i>Monthly Revenue
                </div>
                <div class="card-header-sub">Last 6 months</div>
            </div>
            <div class="card-body pt-2">
                <canvas id="monthlyRevenueChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header-clean">
                <div class="card-header-title">
                    <i class="fas fa-trophy me-2"></i>Top 5 Products
                </div>
                <div class="card-header-sub">By units sold</div>
            </div>
            <div class="card-body pt-2">
                <canvas id="topProductsChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header-clean">
                <div class="card-header-title">
                    <i class="fas fa-user-tie me-2"></i>Orders by Sales Rep
                </div>
            </div>
            <div class="card-body pt-2">
                <canvas id="repOrdersChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header-clean d-flex justify-content-between align-items-center">
                <div>
                    <div class="card-header-title">
                        <i class="fas fa-history me-2"></i>Recent Activity
                    </div>
                </div>
                <a href="{{ route('activity.log') }}" class="view-all-link">View All</a>
            </div>
            <div class="card-body p-0">
                @forelse($recentActivities as $log)
                <div class="activity-row">
                    <div class="activity-dot-wrap">
                        <div class="activity-dot" style="background:
                            {{ $log->action == 'Login' ? '#27ae60' :
                               ($log->action == 'Logout' ? '#e74c3c' :
                               ($log->action == 'Created' ? '#2d6a9f' : '#e67e22')) }}">
                        </div>
                    </div>
                    <div class="activity-body">
                        <div class="activity-text">{{ $log->description }}</div>
                        <div class="activity-time">{{ $log->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="activity-badge-wrap">
                        <span class="activity-module">{{ $log->module }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4" style="font-size:13px;">
                    No activity yet
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Bottom Row -->
<div class="row g-3 mb-3">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header-clean d-flex justify-content-between align-items-center">
                <div class="card-header-title">
                    <i class="fas fa-clipboard-list me-2"></i>Recent Orders
                </div>
                <a href="{{ route('orders.index') }}" class="view-all-link">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Shop</th>
                            <th>Rep</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->shop->shop_name }}</td>
                            <td class="text-muted">{{ $order->user->name ?? 'N/A' }}</td>
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
                            <td colspan="5" class="text-center text-muted py-3">No orders yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header-clean d-flex justify-content-between align-items-center">
                <div class="card-header-title">
                    <i class="fas fa-exclamation-triangle me-2" style="color:#e74c3c;"></i>Low Stock Alerts
                </div>
                <a href="{{ route('products.index') }}" class="view-all-link">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Stock</th>
                            <th>Min</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockItems as $item)
                        <tr>
                            <td style="font-size:12px;">{{ $item->name }}</td>
                            <td><span class="dash-badge red">{{ $item->stock_qty }}</span></td>
                            <td><span class="dash-badge gray">{{ $item->min_stock_level }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">
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

<!-- Quick Access -->
<div class="card mb-3">
    <div class="card-header-clean">
        <div class="card-header-title">
            <i class="fas fa-bolt me-2" style="color:#f0c040;"></i>Quick Access
        </div>
    </div>
    <div class="card-body">
        <div class="row g-2">
            <div class="col">
                <a href="{{ route('products.index') }}" class="quick-btn">
                    <i class="fas fa-box"></i>
                    <span>Inventory</span>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('shops.index') }}" class="quick-btn">
                    <i class="fas fa-store"></i>
                    <span>Shops</span>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('orders.index') }}" class="quick-btn">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Orders</span>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('deliveries.index') }}" class="quick-btn">
                    <i class="fas fa-truck"></i>
                    <span>Deliveries</span>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('invoices.index') }}" class="quick-btn">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Invoices</span>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('reports.stock') }}" class="quick-btn">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('users.index') }}" class="quick-btn">
                    <i class="fas fa-users"></i>
                    <span>Sales Reps</span>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('notifications.index') }}" class="quick-btn">
                    <i class="fas fa-bell"></i>
                    <span>Notifications</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<style>
    /* Welcome Bar */
    .welcome-bar { background:white; border-radius:12px; padding:16px 22px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 1px 6px rgba(0,0,0,0.06); margin-bottom:0; }
    .welcome-title { font-size:16px; font-weight:700; color:#0f2744; }
    .welcome-sub { font-size:12px; color:#94a3b8; margin-top:2px; }
    .welcome-badge { background:#f0fff4; border:1px solid #c6f6d5; color:#276749; font-size:11px; padding:6px 14px; border-radius:20px; font-weight:500; display:flex; align-items:center; gap:6px; }
    .status-dot { width:7px; height:7px; background:#27ae60; border-radius:50%; display:inline-block; }

    /* Stat Cards */
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
    .stat-icon.teal { background:#e8f8f5; color:#1abc9c; }

    /* Revenue Banner */
    .revenue-banner { background:linear-gradient(135deg, #0f2744 0%, #2d6a9f 100%); border-radius:12px; padding:18px 24px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 4px 15px rgba(15,39,68,0.25); }
    .revenue-banner-left { display:flex; align-items:center; gap:16px; }
    .revenue-banner-icon { width:46px; height:46px; background:rgba(255,255,255,0.15); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; color:white; }
    .revenue-banner-label { font-size:12px; color:rgba(255,255,255,0.7); margin-bottom:4px; }
    .revenue-banner-value { font-size:22px; font-weight:700; color:white; }
    .revenue-banner-right { display:flex; align-items:center; gap:20px; }
    .revenue-meta-item { text-align:center; }
    .revenue-meta-value { font-size:18px; font-weight:700; color:white; }
    .revenue-meta-label { font-size:10px; color:rgba(255,255,255,0.6); margin-top:2px; }
    .revenue-meta-divider { width:1px; height:35px; background:rgba(255,255,255,0.15); }

    /* Cards */
    .card { border:1px solid #f1f5f9; border-radius:12px; box-shadow:0 1px 6px rgba(0,0,0,0.05); }
    .card-header-clean { padding:14px 18px 10px; border-bottom:1px solid #f8fafc; display:flex; justify-content:space-between; align-items:center; }
    .card-header-title { font-size:13px; font-weight:600; color:#0f2744; display:flex; align-items:center; }
    .card-header-title i { color:#2d6a9f; }
    .card-header-sub { font-size:11px; color:#94a3b8; }
    .view-all-link { font-size:11px; color:#2d6a9f; text-decoration:none; font-weight:600; }
    .view-all-link:hover { text-decoration:underline; }

    /* Pie legend */
    .pie-legend { display:flex; gap:16px; }
    .pie-legend-item { display:flex; align-items:center; gap:6px; font-size:12px; color:#64748b; }
    .pie-dot { width:10px; height:10px; border-radius:50%; display:inline-block; }

    /* Activity */
    .activity-row { display:flex; align-items:flex-start; gap:12px; padding:10px 16px; border-bottom:1px solid #f8fafc; }
    .activity-dot-wrap { padding-top:3px; flex-shrink:0; }
    .activity-dot { width:8px; height:8px; border-radius:50%; }
    .activity-body { flex:1; }
    .activity-text { font-size:12px; color:#334155; font-weight:500; }
    .activity-time { font-size:10px; color:#94a3b8; margin-top:2px; }
    .activity-badge-wrap { flex-shrink:0; }
    .activity-module { font-size:10px; background:#f1f5f9; color:#64748b; padding:2px 8px; border-radius:10px; }

    /* Dash Table */
    .dash-table { width:100%; border-collapse:collapse; }
    .dash-table thead tr { background:#fafbfc; }
    .dash-table thead th { padding:10px 16px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px; border-bottom:1px solid #f1f5f9; }
    .dash-table tbody td { padding:10px 16px; font-size:12px; color:#334155; border-bottom:1px solid #f8fafc; vertical-align:middle; }
    .dash-table tbody tr:last-child td { border-bottom:none; }
    .dash-table tbody tr:hover td { background:#fafbfd; }

    /* Dash Badges */
    .dash-badge { padding:3px 9px; border-radius:6px; font-size:10px; font-weight:600; }
    .dash-badge.green { background:#eafaf1; color:#27ae60; }
    .dash-badge.yellow { background:#fef9e7; color:#d4930a; }
    .dash-badge.blue { background:#e8f4fd; color:#2d6a9f; }
    .dash-badge.red { background:#fff5f5; color:#e74c3c; }
    .dash-badge.gray { background:#f1f5f9; color:#64748b; }

    /* Quick Access */
    .quick-btn { display:flex; flex-direction:column; align-items:center; gap:8px; padding:14px 10px; border-radius:10px; border:1px solid #f1f5f9; text-decoration:none; transition:all 0.2s; background:white; color:#0f2744; font-size:11px; font-weight:600; text-align:center; }
    .quick-btn i { font-size:18px; color:#2d6a9f; }
    .quick-btn:hover { border-color:#2d6a9f; background:#f0f6ff; color:#0f2744; transform:translateY(-2px); box-shadow:0 4px 12px rgba(45,106,159,0.1); }

    /* Text colors */
    .text-success { color:#27ae60 !important; }
    .text-danger { color:#e74c3c !important; }
    .text-warning { color:#d4930a !important; }
    .text-muted { color:#94a3b8 !important; font-size:11px; }
</style>

<script>
// Daily Orders Chart
new Chart(document.getElementById('dailyOrdersChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($dailyLabels) !!},
        datasets: [{
            label: 'Orders',
            data: {!! json_encode($dailyOrders) !!},
            backgroundColor: 'rgba(45,106,159,0.15)',
            borderColor: '#2d6a9f',
            borderWidth: 2,
            borderRadius: 6,
            hoverBackgroundColor: 'rgba(45,106,159,0.3)',
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 }, color: '#94a3b8' }, grid: { color: '#f8fafc' }, border: { display: false } },
            x: { ticks: { font: { size: 11 }, color: '#94a3b8' }, grid: { display: false }, border: { display: false } }
        }
    }
});

// Payment Pie
new Chart(document.getElementById('paymentPieChart'), {
    type: 'doughnut',
    data: {
        labels: ['Paid', 'Unpaid'],
        datasets: [{
            data: [{{ $paidCount }}, {{ $unpaidCount }}],
            backgroundColor: ['#27ae60', '#e74c3c'],
            borderWidth: 0,
            hoverOffset: 4,
        }]
    },
    options: {
        responsive: true,
        cutout: '70%',
        plugins: { legend: { display: false } }
    }
});

// Monthly Revenue
new Chart(document.getElementById('monthlyRevenueChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyLabels) !!},
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode($monthlyRevenue) !!},
            borderColor: '#2d6a9f',
            backgroundColor: 'rgba(45,106,159,0.06)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#2d6a9f',
            pointRadius: 3,
            pointHoverRadius: 5,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { font: { size: 11 }, color: '#94a3b8' }, grid: { color: '#f8fafc' }, border: { display: false } },
            x: { ticks: { font: { size: 11 }, color: '#94a3b8' }, grid: { display: false }, border: { display: false } }
        }
    }
});

// Top Products
new Chart(document.getElementById('topProductsChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($topProductLabels) !!},
        datasets: [{
            label: 'Units Sold',
            data: {!! json_encode($topProductData) !!},
            backgroundColor: ['rgba(45,106,159,0.7)','rgba(39,174,96,0.7)','rgba(230,126,34,0.7)','rgba(155,89,182,0.7)','rgba(231,76,60,0.7)'],
            borderRadius: 6,
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        indexAxis: 'y',
        plugins: { legend: { display: false } },
        scales: {
            x: { beginAtZero: true, ticks: { font: { size: 11 }, color: '#94a3b8' }, grid: { color: '#f8fafc' }, border: { display: false } },
            y: { ticks: { font: { size: 10 }, color: '#94a3b8' }, grid: { display: false }, border: { display: false } }
        }
    }
});

// Sales Rep Chart
new Chart(document.getElementById('repOrdersChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($repLabels) !!},
        datasets: [{
            label: 'Orders',
            data: {!! json_encode($repData) !!},
            backgroundColor: 'rgba(155,89,182,0.15)',
            borderColor: '#9b59b6',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 }, color: '#94a3b8' }, grid: { color: '#f8fafc' }, border: { display: false } },
            x: { ticks: { font: { size: 11 }, color: '#94a3b8' }, grid: { display: false }, border: { display: false } }
        }
    }
});
</script>
@endsection