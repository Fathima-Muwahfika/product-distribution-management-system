@extends('layouts.app')
@section('page-title', 'Invoice Management')

@section('content')

<div class="card">
    <div class="card-header-clean d-flex justify-content-between align-items-center">
        <div class="card-header-title">
            <i class="fas fa-file-invoice-dollar me-2"></i>All Invoices
        </div>
        <span class="count-badge">{{ $invoices->total() }} Invoices</span>
    </div>

    <!-- Filter -->
    <div class="px-3 pt-3 pb-2">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Unpaid" {{ request('status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm px-3">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
            </div>
            <div class="col-auto">
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary btn-sm px-3">Reset</a>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        <table class="clean-table">
            <thead>
                <tr>
                    <th class="px-3">#</th>
                    <th>Invoice No</th>
                    <th>Shop</th>
                    <th>Order No</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                <tr>
                    <td class="px-3 text-muted">{{ $loop->iteration }}</td>
                    <td><span class="fw-600">{{ $invoice->invoice_number }}</span></td>
                    <td>{{ $invoice->shop->shop_name }}</td>
                    <td class="text-muted">{{ $invoice->order->order_number }}</td>
                    <td class="text-muted">{{ $invoice->invoice_date }}</td>
                    <td><span class="fw-600">LKR {{ number_format($invoice->total_amount, 2) }}</span></td>
                    <td>
                        @if($invoice->payment_status == 'Paid')
                            <span class="status-pill ok">Paid</span>
                        @elseif($invoice->invoice_date <= now()->subDays(30)->toDateString())
                            <span class="status-pill danger">Overdue</span>
                        @else
                            <span class="status-pill warning">Unpaid</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('invoices.show', $invoice) }}"
                                class="action-btn view" title="View Invoice">
                                <i class="fas fa-eye"></i>
                            </a>
                            <div class="action-divider"></div>
                            <a href="{{ route('invoices.pdf', $invoice) }}"
                                class="action-btn pdf" title="Download PDF" target="_blank">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            @if($invoice->payment_status == 'Unpaid')
                            <div class="action-divider"></div>
                            <form action="{{ route('invoices.pay', $invoice) }}"
                                method="POST" class="d-inline"
                                onsubmit="return confirm('Mark as paid?')">
                                @csrf
                                <button type="submit" class="action-btn pay" title="Mark as Paid">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="fas fa-file-invoice fa-2x d-block mb-2 text-muted"></i>
                        <span class="text-muted">No invoices found.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 py-2">{{ $invoices->links() }}</div>
</div>

@endsection

@section('scripts')
<style>
    .card { border:1px solid #f1f5f9; border-radius:12px; box-shadow:0 1px 6px rgba(0,0,0,0.05); }
    .card-header-clean { padding:14px 18px; border-bottom:1px solid #f1f5f9; }
    .card-header-title { font-size:13px; font-weight:600; color:#0f2744; display:flex; align-items:center; }
    .card-header-title i { color:#2d6a9f; }
    .count-badge { background:#f1f5f9; color:#64748b; font-size:11px; font-weight:600; padding:4px 12px; border-radius:20px; }
    .clean-table { width:100%; border-collapse:collapse; }
    .clean-table thead tr { background:#fafbfc; }
    .clean-table thead th { padding:11px 14px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px; border-bottom:1px solid #f1f5f9; white-space:nowrap; }
    .clean-table tbody td { padding:11px 14px; font-size:12.5px; color:#334155; border-bottom:1px solid #f8fafc; vertical-align:middle; }
    .clean-table tbody tr:last-child td { border-bottom:none; }
    .clean-table tbody tr:hover td { background:#fafbfd; }
    .fw-600 { font-weight:600; }
    .text-muted { color:#94a3b8 !important; font-size:12px; }
    .status-pill { padding:3px 10px; border-radius:20px; font-size:10.5px; font-weight:600; display:inline-block; }
    .status-pill.ok { background:#eafaf1; color:#27ae60; border:1px solid #c6f6d5; }
    .status-pill.warning { background:#fef9e7; color:#d4930a; border:1px solid #fde68a; }
    .status-pill.danger { background:#fff5f5; color:#e74c3c; border:1px solid #fecaca; }
    .action-group { display:inline-flex; align-items:center; background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; overflow:hidden; }
    .action-btn { width:32px; height:30px; display:flex; align-items:center; justify-content:center; font-size:12px; border:none; background:transparent; cursor:pointer; transition:all 0.15s; text-decoration:none; color:#64748b; padding:0; }
    .action-btn.view:hover { background:#e8f4fd; color:#2d6a9f; }
    .action-btn.pdf:hover { background:#fff5f5; color:#e74c3c; }
    .action-btn.pay:hover { background:#eafaf1; color:#27ae60; }
    .action-divider { width:1px; height:18px; background:#e2e8f0; flex-shrink:0; }
    .form-control, .form-select { border:1.5px solid #e2e8f0; border-radius:8px; font-size:12.5px; }
    .form-control:focus, .form-select:focus { border-color:#2d6a9f; box-shadow:0 0 0 3px rgba(45,106,159,0.08); }
    .btn-primary { background:#0f2744; border-color:#0f2744; font-size:12.5px; }
    .btn-primary:hover { background:#2d6a9f; border-color:#2d6a9f; }
    .btn-secondary { font-size:12.5px; }
</style>
@endsection