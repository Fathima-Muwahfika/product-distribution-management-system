@extends('layouts.app')
@section('page-title', 'Update Delivery')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header">
        <i class="fas fa-truck me-2" style="color:#e67e22;"></i> Update Delivery — {{ $delivery->order->order_number }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('deliveries.update', $delivery) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Driver Name</label>
                    <input type="text" name="driver_name" class="form-control" value="{{ old('driver_name', $delivery->driver_name) }}" placeholder="Enter driver name">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Delivery Date</label>
                    <input type="date" name="delivery_date" class="form-control" value="{{ old('delivery_date', $delivery->delivery_date) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select">
                        <option value="Pending" {{ $delivery->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Out for Delivery" {{ $delivery->status == 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                        <option value="Delivered" {{ $delivery->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Optional notes...">{{ old('notes', $delivery->notes) }}</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save me-1"></i> Update Delivery
                </button>
                <a href="{{ route('deliveries.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection