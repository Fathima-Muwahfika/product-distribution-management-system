@extends('layouts.app')
@section('page-title', 'Sales Rep Details')

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center py-4">
                <div style="width:70px;height:70px;background:linear-gradient(135deg,#0f2744,#2d6a9f);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:26px;margin:0 auto 15px;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-3" style="font-size:13px;">Sales Representative</p>
                @if($user->status == 'Active')
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </div>
            <div class="card-body pt-0">
                <table class="table table-bordered" style="font-size:13px;">
                    <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                    <tr><th>Phone</th><td>{{ $user->phone }}</td></tr>
                    <tr><th>Area</th><td>{{ $user->area }}</td></tr>
                    <tr><th>Total Orders</th><td><span class="badge bg-primary">{{ $orders->count() }}</span></td></tr>
                    <tr><th>Joined</th><td>{{ $user->created_at->format('d M Y') }}</td></tr>
                </table>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm flex-fill">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm flex-fill">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-clipboard-list me-2" style="color:#2d6a9f;"></i> Recent Orders by {{ $user->name }}
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="px-3">Order No</th>
                            <th>Shop</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="px-3"><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->shop->shop_name }}</td>
                            <td>{{ $order->order_date }}</td>
                            <td>LKR {{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                @if($order->status == 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($order->status == 'Delivered')
                                    <span class="badge bg-success">Delivered</span>
                                @else
                                    <span class="badge bg-info text-white">{{ $order->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No orders yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection