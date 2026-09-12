@extends('layouts.salesrep')
@section('page-title', 'Product Catalog')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-box me-2" style="color:#2d6a9f;"></i> Product Catalog
        <span class="badge bg-primary ms-2">{{ count($products) }} Products</span>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="px-4">#</th>
                    <th>Code</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Source</th>
                    <th>MRP</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="px-4">{{ $loop->iteration }}</td>
                    <td><span class="badge bg-secondary">{{ $product->product_code }}</span></td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td>{{ $product->category }}</td>
                    <td>
                        @if($product->source == 'Import')
                            <span class="badge bg-info">Import 🌏</span>
                        @else
                            <span class="badge bg-success">Local 🇱🇰</span>
                        @endif
                    </td>
                    <td>LKR {{ number_format($product->mrp, 2) }}</td>
                    <td>
                        @if($product->stock_qty <= $product->min_stock_level)
                            <span class="badge bg-danger">{{ $product->stock_qty }} ⚠️</span>
                        @elseif($product->stock_qty <= $product->min_stock_level * 2)
                            <span class="badge bg-warning text-dark">{{ $product->stock_qty }}</span>
                        @else
                            <span class="badge bg-success">{{ $product->stock_qty }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection