@extends('layouts.app')
@section('page-title', 'Product Details')

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-box me-2" style="color:#2d6a9f;"></i> Product Info
            </div>
            <div class="card-body p-0">
                @php
                    $profit = $product->cost_price > 0
                        ? round((($product->mrp - $product->cost_price) / $product->cost_price) * 100, 1)
                        : 0;
                @endphp
                <table class="table table-bordered mb-0" style="font-size:13px;">
                    <tr><th class="px-3">Code</th><td class="px-3"><span class="badge bg-secondary">{{ $product->product_code }}</span></td></tr>
                    <tr><th class="px-3">Name</th><td class="px-3"><strong>{{ $product->name }}</strong></td></tr>
                    <tr><th class="px-3">Category</th><td class="px-3">{{ $product->category }}</td></tr>
                    <tr><th class="px-3">Source</th><td class="px-3">{{ $product->source }}</td></tr>
                    <tr><th class="px-3">Carton Qty</th><td class="px-3">{{ $product->carton_qty }}</td></tr>
                    <tr><th class="px-3">Cost Price</th><td class="px-3">LKR {{ number_format($product->cost_price, 2) }}</td></tr>
                    <tr><th class="px-3">MRP</th><td class="px-3">LKR {{ number_format($product->mrp, 2) }}</td></tr>
                    <tr><th class="px-3">Profit Margin</th><td class="px-3">
                        <span class="badge {{ $profit >= 20 ? 'bg-success' : ($profit >= 10 ? 'bg-warning text-dark' : 'bg-danger') }}">
                            {{ $profit }}%
                        </span>
                    </td></tr>
                    <tr><th class="px-3">Stock Qty</th><td class="px-3">
                        @if($product->stock_qty <= $product->min_stock_level)
                            <span class="badge bg-danger">{{ $product->stock_qty }} ⚠️ Low!</span>
                        @else
                            <span class="badge bg-success">{{ $product->stock_qty }}</span>
                        @endif
                    </td></tr>
                    <tr><th class="px-3">Min Level</th><td class="px-3">{{ $product->min_stock_level }}</td></tr>
                </table>
            </div>
            <div class="card-body">
                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm w-100 mb-2">
                    <i class="fas fa-edit me-1"></i> Edit Product
                </a>
                <a href="{{ route('products.history', $product) }}" class="btn btn-info btn-sm w-100 text-white mb-2">
                    <i class="fas fa-history me-1"></i> Stock History
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm w-100">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>
    </div>

    <!-- Stock IN Form -->
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-plus-circle me-2" style="color:#27ae60;"></i> Add Stock IN
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('products.stockIn', $product) }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Quantity *</label>
                            <input type="number" name="quantity" class="form-control" min="1" placeholder="e.g. 50" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Source *</label>
                            <select name="source" class="form-select" required>
                                <option value="">-- Select Source --</option>
                                <option value="Local - Colombo">Local — Colombo 🇱🇰</option>
                                <option value="Import - China">Import — China 🌏</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Notes</label>
                            <input type="text" name="notes" class="form-control" placeholder="Optional notes...">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cost Price (LKR)</label>
                            <input type="number" step="0.01" name="cost_price" class="form-control"
                                value="{{ number_format($product->cost_price, 2) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">MRP (LKR)</label>
                            <input type="number" step="0.01" name="mrp" class="form-control"
                                value="{{ number_format($product->mrp, 2) }}">
                        </div>
                        
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i> Add to Stock
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stock Batches (same product code, different prices over time) -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-layer-group me-2" style="color:#3b5bdb;"></i> Stock Batches
                <span class="text-muted" style="font-size:12px; font-weight:normal;">
                    — same product code ({{ $product->product_code }}), tracked separately by price
                </span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="px-3">Batch</th>
                            <th>Cost Price</th>
                            <th>MRP</th>
                            <th>Qty Added</th>
                            <th>Remaining</th>
                            <th>Source</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($batches as $batch)
                        <tr>
                            <td class="px-3">
                                <span class="badge bg-secondary">
                                    {{ $loop->first ? 'Latest' : ($loop->last ? 'Batch 1 (Oldest)' : 'Batch') }}
                                </span>
                            </td>
                            <td>LKR {{ number_format($batch->cost_price, 2) }}</td>
                            <td><strong>LKR {{ number_format($batch->mrp, 2) }}</strong></td>
                            <td>{{ $batch->quantity }}</td>
                            <td>
                                @if($batch->remaining_qty <= 0)
                                    <span class="badge bg-danger">0 (Depleted)</span>
                                @else
                                    <span class="badge bg-success">{{ $batch->remaining_qty }}</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $batch->source ?? '—' }}</td>
                            <td class="text-muted">{{ $batch->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-3">No batches yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Stock History -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-history me-2" style="color:#64748b;"></i> Recent Stock History</span>
                <a href="{{ route('products.history', $product) }}" style="font-size:12px;" class="text-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="px-3">Type</th>
                            <th>Quantity</th>
                            <th>Source</th>
                            <th>By</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $log)
                        <tr>
                            <td class="px-3">
                                @if($log->type == 'Stock IN')
                                    <span class="badge bg-success">Stock IN ↑</span>
                                @else
                                    <span class="badge bg-danger">Stock OUT ↓</span>
                                @endif
                            </td>
                            <td><strong>{{ $log->quantity }}</strong></td>
                            <td>{{ $log->source ?? '—' }}</td>
                            <td>{{ $log->user->name ?? 'System' }}</td>
                            <td>{{ $log->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">No history yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection