@extends('layouts.app')
@section('page-title', 'Add New Product')

@section('content')
<div class="card" style="max-width:700px;">
    <div class="card-header">
        <i class="fas fa-plus me-2" style="color:#2d6a9f;"></i> Add New Product
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('products.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Product Code</label>
                    <input type="text" class="form-control" value="Auto-generated on save" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Product Name *</label>
                    <input type="text" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="e.g. Big Jumbo Broom">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category *</label>
                    <select name="category" id="categorySelect"
                        class="form-select @error('category') is-invalid @enderror"
                        onchange="document.getElementById('customCategoryWrap').style.display = (this.value === 'Other') ? 'block' : 'none';">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
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
                    <select name="source"
                        class="form-select @error('source') is-invalid @enderror">
                        <option value="">-- Select Source --</option>
                        <option value="Local" {{ old('source') == 'Local' ? 'selected' : '' }}>
                            Local 🇱🇰 (Colombo)
                        </option>
                        <option value="Import" {{ old('source') == 'Import' ? 'selected' : '' }}>
                            Import 🌏 (China)
                        </option>
                    </select>
                    @error('source')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Carton Qty *</label>
                    <input type="number" name="carton_qty"
                        class="form-control @error('carton_qty') is-invalid @enderror"
                        value="{{ old('carton_qty') }}"
                        placeholder="e.g. 30">
                    @error('carton_qty')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cost Price (LKR) *</label>
                    <input type="number" step="0.01" name="cost_price"
                        class="form-control @error('cost_price') is-invalid @enderror"
                        value="{{ old('cost_price') }}"
                        placeholder="e.g. 584.50">
                    @error('cost_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">MRP (LKR) *</label>
                    <input type="number" step="0.01" name="mrp"
                        class="form-control @error('mrp') is-invalid @enderror"
                        value="{{ old('mrp') }}"
                        placeholder="e.g. 835.00">
                    @error('mrp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Opening Stock Qty *</label>
                    <input type="number" name="stock_qty"
                        class="form-control @error('stock_qty') is-invalid @enderror"
                        value="{{ old('stock_qty', 0) }}"
                        placeholder="e.g. 100">
                    @error('stock_qty')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Minimum Stock Level *</label>
                    <input type="number" name="min_stock_level"
                        class="form-control @error('min_stock_level') is-invalid @enderror"
                        value="{{ old('min_stock_level', 10) }}"
                        placeholder="e.g. 10">
                    @error('min_stock_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Save Product
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection