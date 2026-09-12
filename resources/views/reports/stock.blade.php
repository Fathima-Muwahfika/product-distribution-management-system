@extends('layouts.app')
@section('page-title', 'Stock Report')

@section('content')

<!-- Report Action Bar -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold text-dark mb-1">
            <i class="fas fa-boxes me-2" style="color:#2d6a9f;"></i>Stock Report
        </h5>
        <div style="font-size:12px;color:#94a3b8;">
            Generated on {{ now()->setTimezone('Asia/Colombo')->format('d M Y, h:i A') }}
        </div>
    </div>
    <button onclick="printReport()" class="btn btn-primary btn-sm">
        <i class="fas fa-print me-1"></i> Print Report
    </button>
</div>

<!-- Printable Report Area -->
<div class="card" id="reportArea">
    <div class="card-body p-4">

        <!-- Report Header — shows on print -->
        <div class="report-header">
            <div class="report-header-left">
                <div class="report-company">කැදැල්ල Distributors</div>
                <div class="report-company-en">Kedalla Distributors</div>
                <div class="report-address">Hapugahayatathenna, Handessa, Kandy</div>
                <div class="report-address">077-3737422 / 077-3737202</div>
            </div>
            <div class="report-header-right">
                <div class="report-title">STOCK REPORT</div>
                <div class="report-meta">Generated: {{ now()->setTimezone('Asia/Colombo')->format('d M Y, h:i A') }}</div>
                <div class="report-meta">Total Products: {{ $totalProducts }}</div>
                <div class="report-meta">Low Stock Items: {{ $lowStockCount }}</div>
            </div>
        </div>

        <div class="report-divider"></div>

        <!-- Summary Row -->
        <div class="report-summary">
            <div class="summary-item">
                <div class="summary-value">{{ $totalProducts }}</div>
                <div class="summary-label">Total Products</div>
            </div>
            <div class="summary-item">
                <div class="summary-value text-danger">{{ $lowStockCount }}</div>
                <div class="summary-label">Low Stock</div>
            </div>
            <div class="summary-item">
                <div class="summary-value text-success">{{ $localCount }}</div>
                <div class="summary-label">Local Products</div>
            </div>
            <div class="summary-item">
                <div class="summary-value text-info">{{ $importCount }}</div>
                <div class="summary-label">Import Products</div>
            </div>
        </div>

        <div class="report-divider"></div>

        <!-- Table -->
        <table class="report-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Source</th>
                    <th>Cost Price</th>
                    <th>MRP</th>
                    <th>Profit %</th>
                    <th>Stock Qty</th>
                    <th>Min Level</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                @php
                    $profit = $product->cost_price > 0
                        ? round((($product->mrp - $product->cost_price) / $product->cost_price) * 100, 1)
                        : 0;
                @endphp
                <tr class="{{ $product->stock_qty <= $product->min_stock_level ? 'row-low-stock' : '' }}">
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $product->product_code }}</strong></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->source }}</td>
                    <td>{{ number_format($product->cost_price, 2) }}</td>
                    <td>{{ number_format($product->mrp, 2) }}</td>
                    <td>{{ $profit }}%</td>
                    <td>
                        <strong>{{ $product->stock_qty }}</strong>
                    </td>
                    <td>{{ $product->min_stock_level }}</td>
                    <td>
                        @if($product->stock_qty <= $product->min_stock_level)
                            <span class="status-badge status-low">Low Stock</span>
                        @else
                            <span class="status-badge status-ok">In Stock</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" style="text-align:center;padding:20px;color:#94a3b8;">
                        No products found.
                    </td>
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
    /* Screen styles */
    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }
    .report-company {
        font-size: 18px;
        font-weight: 700;
        color: #0f2744;
        font-family: 'Times New Roman', serif;
    }
    .report-company-en {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 3px;
    }
    .report-address {
        font-size: 11px;
        color: #64748b;
        line-height: 1.6;
    }
    .report-header-right { text-align: right; }
    .report-title {
        font-size: 16px;
        font-weight: 700;
        color: #0f2744;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }
    .report-meta { font-size: 11px; color: #64748b; line-height: 1.7; }

    .report-divider {
        border: none;
        border-top: 2px solid #0f2744;
        margin: 12px 0;
    }

    .report-summary {
        display: flex;
        gap: 30px;
        margin-bottom: 16px;
        padding: 12px 16px;
        background: #f8fafc;
        border-radius: 8px;
    }
    .summary-item { text-align: center; }
    .summary-value { font-size: 22px; font-weight: 700; color: #0f2744; }
    .summary-label { font-size: 11px; color: #64748b; }

    /* Report Table */
    .report-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    .report-table thead tr {
        background: #0f2744;
    }
    .report-table thead th {
        color: white;
        padding: 10px 12px;
        font-size: 11px;
        font-weight: 600;
        text-align: left;
        letter-spacing: 0.3px;
    }
    .report-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
    }
    .report-table tbody tr:nth-child(even) {
        background: #f8fafc;
    }
    .report-table tbody tr:hover {
        background: #f0f6ff;
    }
    .report-table tbody td {
        padding: 9px 12px;
        color: #334155;
    }
    .row-low-stock { background: #fff5f5 !important; }

    .status-badge {
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 600;
    }
    .status-ok { background: #eafaf1; color: #27ae60; }
    .status-low { background: #fff5f5; color: #e74c3c; }
    .status-paid { background: #eafaf1; color: #27ae60; }
    .status-unpaid { background: #fff5f5; color: #e74c3c; }
    .status-overdue { background: #fef9e7; color: #e67e22; }
    .status-delivered { background: #eafaf1; color: #27ae60; }
    .status-pending { background: #fef9e7; color: #e67e22; }
    .status-outfordelivery { background: #e8f4fd; color: #2d6a9f; }

    .report-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 16px;
        padding-top: 10px;
        border-top: 1px solid #e2e8f0;
        font-size: 10px;
        color: #94a3b8;
    }

    /* Print styles */
    @media print {
        body * { visibility: hidden; }
        #reportArea, #reportArea * { visibility: visible; }
        #reportArea { position: absolute; left: 0; top: 0; width: 100%; }
        .card { box-shadow: none !important; border: none !important; }
        .card-body { padding: 10px !important; }
        .report-table { font-size: 10px; }
        .report-table thead th { font-size: 10px; padding: 7px 8px; }
        .report-table tbody td { padding: 6px 8px; }
    }
</style>

<script>
function printReport() {
    window.print();
}
</script>
@endsection