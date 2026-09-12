@extends('layouts.app')
@section('page-title', 'Add New Shop')

@section('content')
<div class="card" style="max-width:680px;">
    <div class="card-header">
        <i class="fas fa-plus me-2" style="color:#2d6a9f;"></i> Add New Shop
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('shops.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Shop Name *</label>
                    <input type="text" name="shop_name"
                        class="form-control @error('shop_name') is-invalid @enderror"
                        value="{{ old('shop_name') }}" placeholder="e.g. Kandy Super Store">
                    @error('shop_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Owner Name *</label>
                    <input type="text" name="owner_name"
                        class="form-control @error('owner_name') is-invalid @enderror"
                        value="{{ old('owner_name') }}" placeholder="e.g. Kamal Perera">
                    @error('owner_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone Number *</label>
                    <input type="text" name="phone"
                        class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone') }}" placeholder="07X-XXXXXXX">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Area *</label>
                    <input type="text" name="area"
                        class="form-control @error('area') is-invalid @enderror"
                        value="{{ old('area') }}" placeholder="e.g. Kandy">
                    @error('area')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label">Address *</label>
                    <textarea name="address" rows="2"
                        class="form-control @error('address') is-invalid @enderror"
                        placeholder="Full address...">{{ old('address') }}</textarea>
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Credit Limit (LKR)</label>
                    <input type="number" step="0.01" name="credit_limit"
                        class="form-control" value="{{ old('credit_limit', 0) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Save Shop
                </button>
                <a href="{{ route('shops.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection