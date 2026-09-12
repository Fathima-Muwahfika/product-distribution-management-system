@extends('layouts.app')
@section('page-title', 'Invoice Details')

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-file-invoice me-2" style="color:#2d6a9f;"></i> Invoice Info
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0" style="font-size:13px;">
                    <tr><th class="px-3">Invoice No</th><td class="px-3"><strong>{{ $invoice->invoice_number }}</strong></td></tr>
                    <tr><th class="px-3">Order No</th><td class="px-3">{{ $invoice->order->order_number }}</td></tr>
                    <tr><th class="px-3">Shop</th><td class="px-3">{{ $invoice->shop->shop_name }}</td></tr>
                    <tr><th class="px-3">Sales Rep</th><td class="px-3">{{ $invoice->order->user->name ?? 'N/A' }}</td></tr>
                    <tr><th class="px-3">Date</th><td class="px-3">{{ $invoice->invoice_date }}</td></tr>
                    <tr><th class="px-3">Amount</th><td class="px-3"><strong>LKR {{ number_format($invoice->total_amount, 2) }}</strong></td></tr>
                    <tr><th class="px-3">Status</th><td class="px-3">
                        @if($invoice->payment_status == 'Paid')
                            <span class="badge bg-success">Paid ✅</span>
                        @else
                            <span class="badge bg-danger">Unpaid</span>
                        @endif
                    </td></tr>
                    @if($invoice->paid_date)
                    <tr><th class="px-3">Paid On</th><td class="px-3">{{ $invoice->paid_date }}</td></tr>
                    @endif
                </table>
            </div>
            <div class="card-body">
                <a href="{{ route('invoices.pdf', $invoice) }}" class="btn btn-secondary btn-sm w-100 mb-2" target="_blank">
                    <i class="fas fa-file-pdf me-1"></i> Download PDF
                </a>
                @if($invoice->payment_status == 'Unpaid')
                <form action="{{ route('invoices.pay', $invoice) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm w-100 mb-2" onclick="return confirm('Mark as paid?')">
                        <i class="fas fa-check me-1"></i> Mark as Paid
                    </button>
                </form>
                @endif
                <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-boxes me-2" style="color:#2d6a9f;"></i> Invoice Items
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
                        @foreach($invoice->order->orderItems as $item)
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
                            <td><strong>LKR {{ number_format($invoice->total_amount, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection