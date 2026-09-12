@extends('layouts.salesrep')
@section('page-title', 'Order Details')

@section('content')

<!-- Status Timeline -->
<div class="card mb-3">
    <div class="card-body">
        <div class="timeline-steps">
            <div class="timeline-step {{ in_array($order->status, ['Pending','Processing','Out for Delivery','Delivered']) ? 'done' : '' }}">
                <div class="step-circle"><i class="fas fa-clipboard-list"></i></div>
                <div class="step-label">Pending</div>
            </div>
            <div class="timeline-line {{ in_array($order->status, ['Processing','Out for Delivery','Delivered']) ? 'done' : '' }}"></div>
            <div class="timeline-step {{ in_array($order->status, ['Processing','Out for Delivery','Delivered']) ? 'done' : '' }}">
                <div class="step-circle"><i class="fas fa-cogs"></i></div>
                <div class="step-label">Processing</div>
            </div>
            <div class="timeline-line {{ in_array($order->status, ['Out for Delivery','Delivered']) ? 'done' : '' }}"></div>
            <div class="timeline-step {{ in_array($order->status, ['Out for Delivery','Delivered']) ? 'done' : '' }}">
                <div class="step-circle"><i class="fas fa-truck"></i></div>
                <div class="step-label">Out for Delivery</div>
            </div>
            <div class="timeline-line {{ $order->status == 'Delivered' ? 'done' : '' }}"></div>
            <div class="timeline-step {{ $order->status == 'Delivered' ? 'done' : '' }}">
                <div class="step-circle"><i class="fas fa-check-circle"></i></div>
                <div class="step-label">Delivered</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle me-2" style="color:#2d6a9f;"></i> Order Info
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0" style="font-size:13px;">
                    <tr><th class="px-3">Order No</th><td class="px-3"><strong>{{ $order->order_number }}</strong></td></tr>
                    <tr><th class="px-3">Shop</th><td class="px-3">{{ $order->shop->shop_name }}</td></tr>
                    <tr><th class="px-3">Date</th><td class="px-3">{{ $order->order_date }}</td></tr>
                    <tr><th class="px-3">Total</th><td class="px-3"><strong>LKR {{ number_format($order->total_amount, 2) }}</strong></td></tr>
                    <tr><th class="px-3">Status</th><td class="px-3">
                        @if($order->status == 'Pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($order->status == 'Processing')
                            <span class="badge bg-info text-white">Processing</span>
                        @elseif($order->status == 'Out for Delivery')
                            <span class="badge bg-primary">Out for Delivery</span>
                        @elseif($order->status == 'Delivered')
                            <span class="badge bg-success">Delivered</span>
                        @endif
                    </td></tr>
                    @if($order->delivery)
                    <tr><th class="px-3">Delivery</th><td class="px-3">
                        <span class="badge {{ $order->delivery->status == 'Delivered' ? 'bg-success' : ($order->delivery->status == 'Out for Delivery' ? 'bg-primary' : 'bg-warning text-dark') }}">
                            {{ $order->delivery->status }}
                        </span>
                    </td></tr>
                    @endif
                    @if($order->notes)
                    <tr><th class="px-3">Notes</th><td class="px-3">{{ $order->notes }}</td></tr>
                    @endif
                </table>
            </div>
            <div class="card-body">
                <a href="{{ route('salesrep.orders') }}" class="btn btn-secondary btn-sm w-100">
                    <i class="fas fa-arrow-left me-1"></i> Back to My Orders
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
                            <th>Code</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td class="px-3">{{ $loop->iteration }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td><span class="badge bg-secondary">{{ $item->product->product_code }}</span></td>
                            <td>{{ $item->quantity }}</td>
                            <td>LKR {{ number_format($item->unit_price, 2) }}</td>
                            <td><strong>LKR {{ number_format($item->subtotal, 2) }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="5" class="text-end fw-bold px-3">Total Amount:</td>
                            <td><strong>LKR {{ number_format($order->total_amount, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .timeline-steps { display:flex; align-items:center; justify-content:center; padding:10px 0; }
    .timeline-step { display:flex; flex-direction:column; align-items:center; }
    .step-circle { width:44px; height:44px; border-radius:50%; background:#e2e8f0; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-size:16px; transition:all 0.3s; }
    .timeline-step.done .step-circle { background:#2d6a9f; color:white; }
    .step-label { font-size:11px; color:#94a3b8; margin-top:6px; font-weight:600; text-align:center; }
    .timeline-step.done .step-label { color:#2d6a9f; }
    .timeline-line { flex:1; height:3px; background:#e2e8f0; margin:0 8px; margin-bottom:20px; }
    .timeline-line.done { background:#2d6a9f; }
</style>
@endsection