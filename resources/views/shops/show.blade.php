@extends('layouts.app')
@section('page-title', 'Shop Details')

@section('content')

<!-- Shop Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#0f2744,#2d6a9f);">
            <div class="stat-icon-box"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <div style="font-size:11px;opacity:0.8;">Total Orders</div>
                <div style="font-size:26px;font-weight:700;">{{ $totalOrders }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#1a7a4a,#27ae60);">
            <div class="stat-icon-box"><i class="fas fa-check-circle"></i></div>
            <div>
                <div style="font-size:11px;opacity:0.8;">Total Paid</div>
                <div style="font-size:20px;font-weight:700;">LKR {{ number_format($totalPaid, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#c0392b,#e74c3c);">
            <div class="stat-icon-box"><i class="fas fa-clock"></i></div>
            <div>
                <div style="font-size:11px;opacity:0.8;">Outstanding Balance</div>
                <div style="font-size:20px;font-weight:700;">LKR {{ number_format($totalUnpaid, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#d35400,#e67e22);">
            <div class="stat-icon-box"><i class="fas fa-exclamation-triangle"></i></div>
            <div>
                <div style="font-size:11px;opacity:0.8;">Overdue Invoices</div>
                <div style="font-size:26px;font-weight:700;">{{ $overdueInvoices }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Shop Info -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-store me-2" style="color:#2d6a9f;"></i> Shop Information
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0" style="font-size:13px;">
                    <tr><th class="px-3">Shop Name</th><td class="px-3"><strong>{{ $shop->shop_name }}</strong></td></tr>
                    <tr><th class="px-3">Owner</th><td class="px-3">{{ $shop->owner_name }}</td></tr>
                    <tr><th class="px-3">Phone</th><td class="px-3">{{ $shop->phone }}</td></tr>
                    <tr><th class="px-3">Area</th><td class="px-3">{{ $shop->area }}</td></tr>
                    <tr><th class="px-3">Address</th><td class="px-3">{{ $shop->address }}</td></tr>
                    <tr><th class="px-3">Credit Limit</th><td class="px-3">LKR {{ number_format($shop->credit_limit, 2) }}</td></tr>
                    <tr><th class="px-3">Status</th><td class="px-3">
                        @if($shop->status == 'Active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td></tr>
                </table>
            </div>
            <div class="card-body">
                <a href="{{ route('shops.edit', $shop) }}" class="btn btn-warning btn-sm w-100 mb-2">
                    <i class="fas fa-edit me-1"></i> Edit Shop
                </a>
                <a href="{{ route('shops.index') }}" class="btn btn-secondary btn-sm w-100">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>
    </div>

    <!-- Orders -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clipboard-list me-2" style="color:#2d6a9f;"></i>Order History</span>
                <span class="badge bg-primary">{{ $totalOrders }} Total Orders</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="px-3">Order No</th>
                            <th>Sales Rep</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="px-3"><strong>{{ $order->order_number }}</strong></td>
                            <td style="font-size:12px;">{{ $order->user->name ?? 'N/A' }}</td>
                            <td>{{ $order->order_date }}</td>
                            <td>LKR {{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                @if($order->status == 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($order->status == 'Delivered')
                                    <span class="badge bg-success">Delivered</span>
                                @elseif($order->status == 'Out for Delivery')
                                    <span class="badge bg-primary">Out for Delivery</span>
                                @else
                                    <span class="badge bg-secondary">{{ $order->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No orders yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
            <div class="card-body">{{ $orders->links() }}</div>
            @endif
        </div>
    </div>
</div>

<style>
.stat-card { border-radius:14px; padding:18px 20px; color:white; display:flex; align-items:center; gap:15px; box-shadow:0 4px 15px rgba(0,0,0,0.12); }
.stat-icon-box { width:45px; height:45px; background:rgba(255,255,255,0.18); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
</style>
@endsection