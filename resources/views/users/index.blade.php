@extends('layouts.app')
@section('page-title', 'Sales Rep Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-users me-2" style="color:#2d6a9f;"></i>All Sales Representatives</span>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Add Sales Rep
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="px-4">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Area</th>
                    <th>Total Orders</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="px-4">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:34px;height:34px;background:linear-gradient(135deg,#0f2744,#2d6a9f);border-radius:9px;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:13px;flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->area }}</td>
                    <td>
                        <span class="badge bg-primary">{{ $user->orders->count() }} Orders</span>
                    </td>
                    <td>
                        @if($user->status == 'Active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('users.show', $user) }}" class="action-btn view" title="View & Edit">
                                <i class="fas fa-eye"></i>
                            </a>
                            <div class="action-divider"></div>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this sales rep?')">
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
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="fas fa-users fa-2x d-block mb-2"></i>No sales reps found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Action group — plain, matches Inventory page style */
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
</style>
@endsection