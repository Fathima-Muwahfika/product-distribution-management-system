@extends('layouts.app')
@section('page-title', 'Shop Management')

@section('content')
<div class="card">
    <div class="card-header-clean d-flex justify-content-between align-items-center">
        <div class="card-header-title">
            <i class="fas fa-store me-2"></i>All Shops
        </div>
        <span class="count-badge">{{ $shops->total() }} Shops</span>
    </div>

    <!-- Filter -->
    <div class="px-3 pt-3 pb-2">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search"
                    class="form-control form-control-sm"
                    placeholder="Search shop name or area..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm px-3">
                    <i class="fas fa-search me-1"></i> Search
                </button>
            </div>
            <div class="col-auto">
                <a href="{{ route('shops.index') }}" class="btn btn-secondary btn-sm px-3">Reset</a>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        <table class="clean-table">
            <thead>
                <tr>
                    <th class="px-3">#</th>
                    <th>Shop Name</th>
                    <th>Owner</th>
                    <th>Phone</th>
                    <th>Area</th>
                    <th>Orders</th>
                    <th>Credit Limit</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shops as $shop)
                <tr>
                    <td class="px-3 text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <span class="fw-600">{{ $shop->shop_name }}</span>
                        <div class="row-sub">{{ $shop->address }}</div>
                    </td>
                    <td>{{ $shop->owner_name }}</td>
                    <td>{{ $shop->phone }}</td>
                    <td>{{ $shop->area }}</td>
                    <td>
                        <span class="count-pill">{{ $shop->orders_count ?? 0 }}</span>
                    </td>
                    <td class="text-muted">LKR {{ number_format($shop->credit_limit, 2) }}</td>
                    <td>
                        @if($shop->status == 'Active')
                            <span class="status-pill ok">Active</span>
                        @else
                            <span class="status-pill gray">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('shops.show', $shop) }}"
                                class="action-btn view" title="View Shop">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <i class="fas fa-store fa-2x d-block mb-2 text-muted"></i>
                        <span class="text-muted">No shops found.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 py-2">{{ $shops->links() }}</div>
</div>
@endsection

@section('scripts')
<style>
    .card { border:1px solid #f1f5f9; border-radius:12px; box-shadow:0 1px 6px rgba(0,0,0,0.05); }
    .card-header-clean { padding:14px 18px; border-bottom:1px solid #f1f5f9; }
    .card-header-title { font-size:13px; font-weight:600; color:#0f2744; display:flex; align-items:center; }
    .card-header-title i { color:#2d6a9f; }
    .count-badge { background:#f1f5f9; color:#64748b; font-size:11px; font-weight:600; padding:4px 12px; border-radius:20px; }
    .clean-table { width:100%; border-collapse:collapse; }
    .clean-table thead tr { background:#fafbfc; }
    .clean-table thead th { padding:11px 14px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px; border-bottom:1px solid #f1f5f9; white-space:nowrap; }
    .clean-table tbody td { padding:11px 14px; font-size:12.5px; color:#334155; border-bottom:1px solid #f8fafc; vertical-align:middle; }
    .clean-table tbody tr:last-child td { border-bottom:none; }
    .clean-table tbody tr:hover td { background:#fafbfd; }
    .fw-600 { font-weight:600; }
    .row-sub { font-size:11px; color:#94a3b8; margin-top:2px; }
    .text-muted { color:#94a3b8 !important; font-size:12px; }
    .count-pill { background:#e8f4fd; color:#2d6a9f; font-size:11px; font-weight:600; padding:3px 10px; border-radius:20px; }
    .status-pill { padding:3px 10px; border-radius:20px; font-size:10.5px; font-weight:600; display:inline-block; }
    .status-pill.ok { background:#eafaf1; color:#27ae60; border:1px solid #c6f6d5; }
    .status-pill.gray { background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0; }
    .action-group { display:inline-flex; align-items:center; background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; overflow:hidden; }
    .action-btn { width:32px; height:30px; display:flex; align-items:center; justify-content:center; font-size:12px; border:none; background:transparent; cursor:pointer; transition:all 0.15s; text-decoration:none; color:#64748b; padding:0; }
    .action-btn.view:hover { background:#e8f4fd; color:#2d6a9f; }
    .form-control, .form-select { border:1.5px solid #e2e8f0; border-radius:8px; font-size:12.5px; }
    .form-control:focus, .form-select:focus { border-color:#2d6a9f; box-shadow:0 0 0 3px rgba(45,106,159,0.08); }
    .btn-primary { background:#0f2744; border-color:#0f2744; font-size:12.5px; }
    .btn-primary:hover { background:#2d6a9f; border-color:#2d6a9f; }
    .btn-secondary { font-size:12.5px; }
</style>
@endsection