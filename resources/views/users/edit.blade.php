@extends('layouts.app')
@section('page-title', 'Edit Sales Rep')

@section('content')
<div class="card" style="max-width:650px;">
    <div class="card-header">
        <i class="fas fa-user-edit me-2" style="color:#e67e22;"></i> Edit Sales Representative
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone Number *</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Area *</label>
                    <input type="text" name="area" class="form-control" value="{{ old('area', $user->area) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select">
                        <option value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ $user->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-12">
                    <hr>
                    <p class="text-muted" style="font-size:12px;"><i class="fas fa-info-circle me-1"></i> Leave password blank to keep existing password</p>
                </div>
                <div class="col-md-6">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i> Update Sales Rep</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection