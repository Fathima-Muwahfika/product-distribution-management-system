@extends('layouts.app')
@section('page-title', 'Order Details')

@section('content')

<!-- Order Status Timeline -->
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
    <!-- Order Info -->
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-info-circle me-2" style="color:#2d6a9f;"></i> Order Information
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0" style="font-size:13px;">
                    <tr><th class="px-3">Order No</th><td class="px-3"><strong>{{ $order->order_number }}</strong></td></tr>
                    <tr><th class="px-3">Shop</th><td class="px-3">{{ $order->shop->shop_name }}</td></tr>
                    <tr><th class="px-3">Sales Rep</th><td class="px-3">{{ $order->user->name ?? 'N/A' }}</td></tr>
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
                    @if($order->notes)
                    <tr><th class="px-3">Notes</th><td class="px-3">{{ $order->notes }}</td></tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Update Status -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-sync me-2" style="color:#e67e22;"></i> Update Status
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('orders.updateStatus', $order) }}">
                    @csrf
                    <select name="status" class="form-select mb-2">
                        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                        <option value="Out for Delivery" {{ $order->status == 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                        <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                    <button type="submit" class="btn btn-warning btn-sm w-100">
                        <i class="fas fa-save me-1"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="col-md-8">
        <div class="card mb-3">
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

        <!-- Invoice & Delivery Info -->
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-file-invoice me-2" style="color:#27ae60;"></i> Invoice
                    </div>
                    <div class="card-body" style="font-size:13px;">
                        @if($order->invoice)
                            <p><strong>Invoice No:</strong> {{ $order->invoice->invoice_number }}</p>
                            <p><strong>Amount:</strong> LKR {{ number_format($order->invoice->total_amount, 2) }}</p>
                            <p><strong>Status:</strong>
                                @if($order->invoice->payment_status == 'Paid')
                                    <span class="badge bg-success">Paid ✅</span>
                                @else
                                    <span class="badge bg-danger">Unpaid</span>
                                @endif
                            </p>
                            <a href="{{ route('invoices.show', $order->invoice) }}" class="btn btn-sm btn-outline-success w-100 mt-2">
                                <i class="fas fa-eye me-1"></i> View Invoice
                            </a>
                        @else
                            <p class="text-muted">No invoice yet</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-truck me-2" style="color:#9b59b6;"></i> Delivery
                    </div>
                    <div class="card-body" style="font-size:13px;">
                        @if($order->delivery)
                            <p><strong>Driver:</strong> {{ $order->delivery->driver_name ?? 'Not assigned' }}</p>
                            <p><strong>Date:</strong> {{ $order->delivery->delivery_date ?? 'Not set' }}</p>
                            <p><strong>Status:</strong>
                                @if($order->delivery->status == 'Delivered')
                                    <span class="badge bg-success">Delivered</span>
                                @elseif($order->delivery->status == 'Out for Delivery')
                                    <span class="badge bg-primary">Out for Delivery</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </p>
                        @else
                            <p class="text-muted">No delivery record</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to Orders
    </a>
</div>
@endsection

@section('scripts')
<style>
    .timeline-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 0;
    }
    .timeline-step { display: flex; flex-direction: column; align-items: center; }
    .step-circle {
        width: 44px; height: 44px;
        border-radius: 50%;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 16px;
        transition: all 0.3s;
    }
    .timeline-step.done .step-circle { background: #2d6a9f; color: white; }
    .step-label { font-size: 11px; color: #94a3b8; margin-top: 6px; font-weight: 600; text-align: center; }
    .timeline-step.done .step-label { color: #2d6a9f; }
    .timeline-line { flex: 1; height: 3px; background: #e2e8f0; margin: 0 8px; margin-bottom: 20px; }
    .timeline-line.done { background: #2d6a9f; }
</style>
@endsection