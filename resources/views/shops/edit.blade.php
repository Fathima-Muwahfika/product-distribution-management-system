@extends('layouts.app')
@section('page-title', 'Edit Shop')

@section('content')
<div class="card" style="max-width:680px;">
    <div class="card-header">
        <i class="fas fa-edit me-2" style="color:#e67e22;"></i> Edit Shop — {{ $shop->shop_name }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('shops.update', $shop) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Shop Name *</label>
                    <input type="text" name="shop_name" class="form-control"
                        value="{{ old('shop_name', $shop->shop_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Owner Name *</label>
                    <input type="text" name="owner_name" class="form-control"
                        value="{{ old('owner_name', $shop->owner_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone Number *</label>
                    <input type="text" name="phone" class="form-control"
                        value="{{ old('phone', $shop->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Area *</label>
                    <input type="text" name="area" class="form-control"
                        value="{{ old('area', $shop->area) }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Address *</label>
                    <textarea name="address" rows="2" class="form-control">{{ old('address', $shop->address) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Credit Limit (LKR)</label>
                    <input type="number" step="0.01" name="credit_limit"
                        class="form-control" value="{{ old('credit_limit', $shop->credit_limit) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Active" {{ $shop->status == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ $shop->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save me-1"></i> Update Shop
                </button>
                <a href="{{ route('shops.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection