@extends('layouts.app')
@section('page-title', 'Sales Rep Performance Report')

@section('content')

<!-- Action Bar -->
<div class="d-flex justify-content-between align-items-center mb-3 no-print">
    <div>
        <h5 class="fw-bold text-dark mb-1">
            <i class="fas fa-user-tie me-2" style="color:#2d6a9f;"></i>Sales Rep Performance Report
        </h5>
        <div style="font-size:12px;color:#94a3b8;">
            Generated on {{ now()->setTimezone('Asia/Colombo')->format('d M Y, h:i A') }}
        </div>
    </div>
    <button onclick="printReport()" class="btn btn-primary btn-sm">
        <i class="fas fa-print me-1"></i> Print Report
    </button>
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
                <div class="report-title">SALES REP PERFORMANCE REPORT</div>
                <div class="report-meta">Generated: {{ now()->setTimezone('Asia/Colombo')->format('d M Y, h:i A') }}</div>
                <div class="report-meta">Total Sales Reps: {{ $reps->count() }}</div>
            </div>
        </div>

        <div class="report-divider"></div>

        <div class="report-summary">
            <div class="summary-item">
                <div class="summary-value">{{ $reps->count() }}</div>
                <div class="summary-label">Total Reps</div>
            </div>
            <div class="summary-item">
                <div class="summary-value text-success">{{ $reps->where('status','Active')->count() }}</div>
                <div class="summary-label">Active Reps</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ $reps->sum('orders_count') }}</div>
                <div class="summary-label">Total Orders</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">LKR {{ number_format($reps->sum('orders_sum_total_amount'), 2) }}</div>
                <div class="summary-label">Total Sales</div>
            </div>
        </div>

        <div class="report-divider"></div>

        <table class="report-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Sales Rep Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Area</th>
                    <th>Total Orders</th>
                    <th>Total Sales (LKR)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reps as $rep)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $rep->name }}</strong></td>
                    <td>{{ $rep->email }}</td>
                    <td>{{ $rep->phone }}</td>
                    <td>{{ $rep->area }}</td>
                    <td><strong>{{ $rep->orders_count }}</strong></td>
                    <td><strong>{{ number_format($rep->orders_sum_total_amount ?? 0, 2) }}</strong></td>
                    <td>
                        @if($rep->status == 'Active')
                            <span class="status-badge status-paid">Active</span>
                        @else
                            <span class="status-badge status-unpaid">Inactive</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:20px;color:#94a3b8;">No sales reps found.</td>
                </tr>
                @endforelse
            </tbody>
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
    .summary-value { font-size:16px; font-weight:700; color:#0f2744; }
    .summary-label { font-size:11px; color:#64748b; }
    .report-table { width:100%; border-collapse:collapse; font-size:12px; }
    .report-table thead tr { background:#0f2744; }
    .report-table thead th { color:white; padding:10px 12px; font-size:11px; font-weight:600; text-align:left; }
    .report-table tbody tr { border-bottom:1px solid #f1f5f9; }
    .report-table tbody tr:nth-child(even) { background:#f8fafc; }
    .report-table tbody tr:hover { background:#f0f6ff; }
    .report-table tbody td { padding:9px 12px; color:#334155; }
    .status-badge { padding:3px 8px; border-radius:4px; font-size:10px; font-weight:600; }
    .status-paid { background:#eafaf1; color:#27ae60; }
    .status-unpaid { background:#fff5f5; color:#e74c3c; }
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