@extends('layouts.app')
@section('page-title', 'Inventory Management')

@section('content')
<div class="card">
    <div class="card-header-clean d-flex justify-content-between align-items-center">
        <div class="card-header-title">
            <i class="fas fa-box me-2"></i>All Products
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Add Product
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="px-3 pt-3 pb-2">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search"
                    class="form-control form-control-sm"
                    placeholder="Search by name or code..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="category" class="form-select form-select-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="source" class="form-select form-select-sm">
                    <option value="">All Sources</option>
                    <option value="Local" {{ request('source') == 'Local' ? 'selected' : '' }}>Local 🇱🇰</option>
                    <option value="Import" {{ request('source') == 'Import' ? 'selected' : '' }}>Import 🌏</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="stock_status" class="form-select form-select-sm">
                    <option value="">All Stock</option>
                    <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock ⚠️</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm px-3">
                    <i class="fas fa-search me-1"></i> Search
                </button>
            </div>
            <div class="col-auto">
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm px-3">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="px-3" style="width:40px;">#</th>
                    <th>Code</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Source</th>
                    <th>Cost Price</th>
                    <th>MRP</th>
                    <th>Profit %</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th style="width:80px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                @php
                    $profit = $product->cost_price > 0
                        ? round((($product->mrp - $product->cost_price) / $product->cost_price) * 100, 1)
                        : 0;
                @endphp
                <tr>
                    <td class="px-3 text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <span class="prod-code">{{ $product->product_code }}</span>
                    </td>
                    <td>
                        <span class="fw-600">{{ $product->name }}</span>
                    </td>
                    <td class="text-muted">{{ $product->category }}</td>
                    <td>
                        @if($product->source == 'Import')
                            <span class="src-badge import">🌏 Import</span>
                        @else
                            <span class="src-badge local">🇱🇰 Local</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ number_format($product->cost_price, 2) }}</td>
                    <td class="fw-600">{{ number_format($product->mrp, 2) }}</td>
                    <td>
                        <span class="profit-badge {{ $profit >= 20 ? 'high' : ($profit >= 10 ? 'mid' : 'low') }}">
                            {{ $profit }}%
                        </span>
                    </td>
                    <td>
                        @if($product->stock_qty <= $product->min_stock_level)
                            <span class="stock-badge danger">{{ $product->stock_qty }}</span>
                        @elseif($product->stock_qty <= $product->min_stock_level * 2)
                            <span class="stock-badge warning">{{ $product->stock_qty }}</span>
                        @else
                            <span class="stock-badge ok">{{ $product->stock_qty }}</span>
                        @endif
                    </td>
                    <td>
                        @if($product->stock_qty <= $product->min_stock_level)
                            <span class="status-pill danger">Low Stock</span>
                        @else
                            <span class="status-pill ok">In Stock</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('products.show', $product) }}"
                                class="action-btn view" title="View & Edit">
                                <i class="fas fa-eye"></i>
                            </a>
                            <div class="action-divider"></div>
                            <form action="{{ route('products.destroy', $product) }}"
                                method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete {{ $product->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center py-5">
                        <i class="fas fa-box fa-2x d-block mb-2 text-muted"></i>
                        <span class="text-muted">No products found.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-3 py-2">
        {{ $products->links() }}
    </div>
</div>
@endsection

@section('scripts')
<style>
    /* Card header */
    .card-header-clean {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
    }
    .card-header-title {
        font-size: 13px;
        font-weight: 600;
        color: #0f2744;
        display: flex;
        align-items: center;
    }
    .card-header-title i { color: #2d6a9f; }

    /* Table */
    .table thead tr { background: #fafbfc; }
    .table thead th {
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #f1f5f9;
        padding: 11px 14px;
        white-space: nowrap;
    }
    .table tbody td {
        padding: 11px 14px;
        font-size: 12.5px;
        color: #334155;
        vertical-align: middle;
        border-bottom: 1px solid #f8fafc;
    }
    .table tbody tr:last-child td { border-bottom: none; }
    .table tbody tr:hover td { background: #fafbfd; }
    .fw-600 { font-weight: 600; }

    /* Product Code */
    .prod-code {
        background: #f1f5f9;
        color: #475569;
        padding: 3px 8px;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 600;
        font-family: monospace;
    }

    /* Source badges */
    .src-badge {
        padding: 3px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
    }
    .src-badge.local { background: #eafaf1; color: #27ae60; }
    .src-badge.import { background: #e8f4fd; color: #2d6a9f; }

    /* Profit badge */
    .profit-badge {
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }
    .profit-badge.high { background: #eafaf1; color: #27ae60; }
    .profit-badge.mid { background: #fef9e7; color: #d4930a; }
    .profit-badge.low { background: #fff5f5; color: #e74c3c; }

    /* Stock badge */
    .stock-badge {
        padding: 3px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
    }
    .stock-badge.ok { background: #eafaf1; color: #27ae60; }
    .stock-badge.warning { background: #fef9e7; color: #d4930a; }
    .stock-badge.danger { background: #fff5f5; color: #e74c3c; }

    /* Status pill */
    .status-pill {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 10.5px;
        font-weight: 600;
        display: inline-block;
    }
    .status-pill.ok { background: #eafaf1; color: #27ae60; border: 1px solid #c6f6d5; }
    .status-pill.danger { background: #fff5f5; color: #e74c3c; border: 1px solid #fecaca; }

    /* Action group */
    .action-group {
        display: inline-flex;
        align-items: center;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
    }
    .action-btn {
        width: 32px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        border: none;
        background: transparent;
        cursor: pointer;
        transition: all 0.15s;
        text-decoration: none;
        color: #64748b;
        padding: 0;
    }
    .action-btn.view:hover { background: #e8f4fd; color: #2d6a9f; }
    .action-btn.delete:hover { background: #fff5f5; color: #e74c3c; }
    .action-divider { width: 1px; height: 18px; background: #e2e8f0; flex-shrink: 0; }

    /* Form control */
    .form-control, .form-select {
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 12.5px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #2d6a9f;
        box-shadow: 0 0 0 3px rgba(45,106,159,0.08);
    }

    /* Button */
    .btn-primary { background: #0f2744; border-color: #0f2744; font-size: 12.5px; }
    .btn-primary:hover { background: #2d6a9f; border-color: #2d6a9f; }
    .btn-secondary { font-size: 12.5px; }
</style>
@endsection