@extends('layouts.app')
@section('page-title', 'Orders Report')

@section('content')

<!-- Filter Bar -->
<div class="card mb-3 no-print">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label" style="font-size:11px;font-weight:600;">FROM DATE</label>
                <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-size:11px;font-weight:600;">TO DATE</label>
                <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label" style="font-size:11px;font-weight:600;">STATUS</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                    <option value="Out for Delivery" {{ request('status') == 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                    <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('reports.orders') }}" class="btn btn-secondary btn-sm">Reset</a>
                <button onclick="printReport()" type="button" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-print me-1"></i> Print
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Printable Report -->
<div class="card" id="reportArea">
    <div class="card-body p-4">

        <div class="report-header">
            <div class="report-header-left">
                <div class="report-company">කැදැල්ල Distributors</div>
                <div class="report-company-en">Kedalla Distributors</div>
                <div class="report-address">Hapugahayatathenna, Handessa, Kandy</div>
                <div class="report-address">077-3737422 / 077-3737202</div>
            </div>
            <div class="report-header-right">
                <div class="report-title">ORDERS REPORT</div>
                <div class="report-meta">Generated: {{ now()->setTimezone('Asia/Colombo')->format('d M Y, h:i A') }}</div>
                @if(request('from_date') && request('to_date'))
                <div class="report-meta">Period: {{ request('from_date') }} to {{ request('to_date') }}</div>
                @endif
                @if(request('status'))
                <div class="report-meta">Status: {{ request('status') }}</div>
                @endif
                <div class="report-meta">Total Orders: {{ $orders->count() }}</div>
            </div>
        </div>

        <div class="report-divider"></div>

        <div class="report-summary">
            <div class="summary-item">
                <div class="summary-value">{{ $orders->count() }}</div>
                <div class="summary-label">Total Orders</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">LKR {{ number_format($totalAmount, 2) }}</div>
                <div class="summary-label">Total Amount</div>
            </div>
            <div class="summary-item">
                <div class="summary-value text-warning">{{ $orders->where('status','Pending')->count() }}</div>
                <div class="summary-label">Pending</div>
            </div>
            <div class="summary-item">
                <div class="summary-value text-success">{{ $orders->where('status','Delivered')->count() }}</div>
                <div class="summary-label">Delivered</div>
            </div>
        </div>

        <div class="report-divider"></div>

        <table class="report-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order No</th>
                    <th>Shop</th>
                    <th>Sales Rep</th>
                    <th>Date</th>
                    <th>Amount (LKR)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>{{ $order->shop->shop_name }}</td>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                    <td>{{ $order->order_date }}</td>
                    <td><strong>{{ number_format($order->total_amount, 2) }}</strong></td>
                    <td>
                        @if($order->status == 'Pending')
                            <span class="status-badge status-pending">Pending</span>
                        @elseif($order->status == 'Delivered')
                            <span class="status-badge status-delivered">Delivered</span>
                        @elseif($order->status == 'Out for Delivery')
                            <span class="status-badge status-outfordelivery">Out for Delivery</span>
                        @else
                            <span class="status-badge" style="background:#f1f5f9;color:#64748b;">{{ $order->status }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:20px;color:#94a3b8;">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
            @if($orders->count() > 0)
            <tfoot>
                <tr style="background:#f8fafc;font-weight:700;">
                    <td colspan="5" style="padding:10px 12px;text-align:right;font-size:12px;">Grand Total:</td>
                    <td style="padding:10px 12px;font-size:13px;">LKR {{ number_format($totalAmount, 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>

        <div class="report-footer">
            <span>කැදැල්ල Distributors — Confidential Report</span>
            <span>Page 1</span>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<style>
    .report-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px; }
    .report-company { font-size:18px; font-weight:700; color:#0f2744; font-family:'Times New Roman',serif; }
    .report-company-en { font-size:13px; font-weight:600; color:#334155; margin-bottom:3px; }
    .report-address { font-size:11px; color:#64748b; line-height:1.6; }
    .report-header-right { text-align:right; }
    .report-title { font-size:16px; font-weight:700; color:#0f2744; letter-spacing:1px; margin-bottom:5px; }
    .report-meta { font-size:11px; color:#64748b; line-height:1.7; }
    .report-divider { border:none; border-top:2px solid #0f2744; margin:12px 0; }
    .report-summary { display:flex; gap:30px; margin-bottom:16px; padding:12px 16px; background:#f8fafc; border-radius:8px; }
    .summary-item { text-align:center; }
    .summary-value { font-size:20px; font-weight:700; color:#0f2744; }
    .summary-label { font-size:11px; color:#64748b; }
    .report-table { width:100%; border-collapse:collapse; font-size:12px; }
    .report-table thead tr { background:#0f2744; }
    .report-table thead th { color:white; padding:10px 12px; font-size:11px; font-weight:600; text-align:left; }
    .report-table tbody tr { border-bottom:1px solid #f1f5f9; }
    .report-table tbody tr:nth-child(even) { background:#f8fafc; }
    .report-table tbody tr:hover { background:#f0f6ff; }
    .report-table tbody td { padding:9px 12px; color:#334155; }
    .status-badge { padding:3px 8px; border-radius:4px; font-size:10px; font-weight:600; }
    .status-delivered { background:#eafaf1; color:#27ae60; }
    .status-pending { background:#fef9e7; color:#e67e22; }
    .status-outfordelivery { background:#e8f4fd; color:#2d6a9f; }
    .report-footer { display:flex; justify-content:space-between; margin-top:16px; padding-top:10px; border-top:1px solid #e2e8f0; font-size:10px; color:#94a3b8; }
    @media print {
        .no-print { display:none !important; }
        body * { visibility:hidden; }
        #reportArea, #reportArea * { visibility:visible; }
        #reportArea { position:absolute; left:0; top:0; width:100%; }
        .card { box-shadow:none !important; border:none !important; }
        .card-body { padding:10px !important; }
        .report-table { font-size:10px; }
        .report-table thead th { font-size:10px; padding:7px 8px; }
        .report-table tbody td { padding:6px 8px; }
    }
</style>
<script>
function printReport() { window.print(); }
</script>
@endsection