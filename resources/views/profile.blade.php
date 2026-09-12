@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.salesrep')
@section('page-title', 'My Profile')

@section('content')
<div class="row g-3">

    <!-- Profile Info Card -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center py-4">
                <div style="width:75px;height:75px;background:linear-gradient(135deg,#0f2744,#2d6a9f);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:28px;margin:0 auto 15px;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ Auth::user()->name }}</h5>
                <p class="text-muted mb-2" style="font-size:13px;">{{ Auth::user()->email }}</p>
                <span class="badge" style="background:#eef4fb;color:#2d6a9f;border:1px solid #c8dff0;font-size:11px;">
                    {{ Auth::user()->role == 'admin' ? 'Administrator' : 'Sales Representative' }}
                </span>
            </div>
            <div class="card-body pt-0">
                <table class="table table-bordered" style="font-size:13px;">
                    <tr><th>Phone</th><td>{{ Auth::user()->phone ?? '—' }}</td></tr>
                    <tr><th>Area</th><td>{{ Auth::user()->area ?? '—' }}</td></tr>
                    <tr><th>Status</th><td>
                        <span class="badge bg-success">{{ Auth::user()->status }}</span>
                    </td></tr>
                    <tr><th>Joined</th><td>{{ Auth::user()->created_at->format('d M Y') }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8">

        <!-- Update Profile -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-user-edit me-2" style="color:#2d6a9f;"></i> Update Profile
            </div>
            <div class="card-body">
                <form method="POST" action="{{ Auth::user()->role == 'admin' ? route('profile.update') : route('salesrep.profile.update') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', Auth::user()->phone) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Area</label>
                            <input type="text" name="area" class="form-control" value="{{ old('area', Auth::user()->area) }}">
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-lock me-2" style="color:#e74c3c;"></i> Change Password
            </div>
            <div class="card-body">
                <form method="POST" action="{{ Auth::user()->role == 'admin' ? route('profile.password') : route('salesrep.profile.password') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Current Password *</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Enter current password">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">New Password *</label>
                            <input type="password" name="password" class="form-control" placeholder="Min 6 characters">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm New Password *</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-key me-1"></i> Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection