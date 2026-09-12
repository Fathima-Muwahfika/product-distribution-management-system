@extends('layouts.app')
@section('page-title', 'Delivery Details')

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-truck me-2" style="color:#2d6a9f;"></i> Delivery Info
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0" style="font-size:13px;">
                    <tr><th class="px-3">Order No</th><td class="px-3"><strong>{{ $delivery->order->order_number }}</strong></td></tr>
                    <tr><th class="px-3">Shop</th><td class="px-3">{{ $delivery->order->shop->shop_name }}</td></tr>
                    <tr><th class="px-3">Driver</th><td class="px-3">{{ $delivery->driver_name ?? 'Not assigned' }}</td></tr>
                    <tr><th class="px-3">Date</th><td class="px-3">{{ $delivery->delivery_date ?? 'Not set' }}</td></tr>
                    <tr><th class="px-3">Status</th><td class="px-3">
                        @if($delivery->status == 'Delivered')
                            <span class="badge bg-success">Delivered</span>
                        @elseif($delivery->status == 'Out for Delivery')
                            <span class="badge bg-primary">Out for Delivery</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td></tr>
                    @if($delivery->notes)
                    <tr><th class="px-3">Notes</th><td class="px-3">{{ $delivery->notes }}</td></tr>
                    @endif
                </table>
            </div>
            <div class="card-body">
                <a href="{{ route('deliveries.edit', $delivery) }}" class="btn btn-warning btn-sm w-100 mb-2">
                    <i class="fas fa-edit me-1"></i> Edit Delivery
                </a>
                <a href="{{ route('deliveries.index') }}" class="btn btn-secondary btn-sm w-100">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-boxes me-2" style="color:#2d6a9f;"></i> Order Items
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="px-3">#</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($delivery->order->orderItems as $item)
                        <tr>
                            <td class="px-3">{{ $loop->iteration }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>LKR {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold px-3">Total:</td>
                            <td><strong>LKR {{ number_format($delivery->order->total_amount, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection