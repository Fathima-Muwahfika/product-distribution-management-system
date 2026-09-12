@extends('layouts.app')
@section('page-title', 'Edit Product')

@section('content')
<div class="card" style="max-width:700px;">
    <div class="card-header">
        <i class="fas fa-edit me-2" style="color:#e67e22;"></i> Edit Product — {{ $product->name }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('products.update', $product) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Product Code</label>
                    <input type="text" class="form-control" value="{{ $product->product_code }}" disabled>
                    <div class="form-text">Auto-generated — cannot be changed.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Product Name *</label>
                    <input type="text" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $product->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category *</label>
                    <select name="category" id="categorySelect" class="form-select @error('category') is-invalid @enderror"
                        onchange="document.getElementById('customCategoryWrap').style.display = (this.value === 'Other') ? 'block' : 'none';">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category', $product->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>+ Add New Category...</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div id="customCategoryWrap" class="mt-2" style="display: {{ old('category') == 'Other' ? 'block' : 'none' }};">
                        <input type="text" name="custom_category"
                            class="form-control @error('custom_category') is-invalid @enderror"
                            placeholder="Type new category name"
                            value="{{ old('custom_category') }}">
                        @error('custom_category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Source *</label>
                    <select name="source" class="form-select">
                        <option value="Local" {{ $product->source == 'Local' ? 'selected' : '' }}>
                            Local 🇱🇰 (Colombo)
                        </option>
                        <option value="Import" {{ $product->source == 'Import' ? 'selected' : '' }}>
                            Import 🌏 (China)
                        </option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Carton Qty *</label>
                    <input type="number" name="carton_qty"
                        class="form-control"
                        value="{{ old('carton_qty', $product->carton_qty) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cost Price (LKR) *</label>
                    <input type="number" step="0.01" name="cost_price"
                        class="form-control"
                        value="{{ old('cost_price', $product->cost_price) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">MRP (LKR) *</label>
                    <input type="number" step="0.01" name="mrp"
                        class="form-control"
                        value="{{ old('mrp', $product->mrp) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Current Stock Qty *</label>
                    <input type="number" name="stock_qty"
                        class="form-control"
                        value="{{ old('stock_qty', $product->stock_qty) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Minimum Stock Level *</label>
                    <input type="number" name="min_stock_level"
                        class="form-control"
                        value="{{ old('min_stock_level', $product->min_stock_level) }}">
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save me-1"></i> Update Product
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection