@extends('layouts.app')
@section('page-title', 'Activity Log')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-history me-2" style="color:#2d6a9f;"></i> System Activity Log
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="px-4">#</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Module</th>
                    <th>Description</th>
                    <th>IP Address</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $log)
                <tr>
                    <td class="px-4">{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $log->user->name ?? 'System' }}</strong>
                        <div style="font-size:11px;color:#94a3b8;">{{ $log->user->role ?? '' }}</div>
                    </td>
                    <td>
                        @if($log->action == 'Login')
                            <span class="badge bg-success">{{ $log->action }}</span>
                        @elseif($log->action == 'Logout')
                            <span class="badge bg-secondary">{{ $log->action }}</span>
                        @elseif($log->action == 'Deleted')
                            <span class="badge bg-danger">{{ $log->action }}</span>
                        @elseif($log->action == 'Created')
                            <span class="badge bg-primary">{{ $log->action }}</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ $log->action }}</span>
                        @endif
                    </td>
                    <td><span class="badge bg-light text-dark border">{{ $log->module }}</span></td>
                    <td style="font-size:13px;">{{ $log->description }}</td>
                    <td style="font-size:12px;color:#94a3b8;">{{ $log->ip_address }}</td>
                    <td style="font-size:12px;color:#94a3b8;">{{ $log->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fas fa-history fa-2x d-block mb-2"></i>No activity yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $activities->links() }}
@endsection