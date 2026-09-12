@extends('layouts.app')
@section('page-title', 'Notifications')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>
            <i class="fas fa-bell me-2" style="color:#2d6a9f;"></i> Notifications
            @if($unreadCount > 0)
                <span class="badge bg-danger ms-1">{{ $unreadCount }} Unread</span>
            @endif
        </span>
        @if($unreadCount > 0)
        <form method="POST" action="{{ route('notifications.readAll') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-check-double me-1"></i> Mark All as Read
            </button>
        </form>
        @endif
    </div>
    <div class="card-body p-0">
        @forelse($notifications as $notif)
        <div class="notif-item {{ $notif->is_read ? 'read' : 'unread' }}">
            <div class="notif-icon {{ $notif->type }}">
                @if($notif->type == 'danger')
                    <i class="fas fa-exclamation-triangle"></i>
                @elseif($notif->type == 'warning')
                    <i class="fas fa-clock"></i>
                @elseif($notif->type == 'info')
                    <i class="fas fa-truck"></i>
                @else
                    <i class="fas fa-bell"></i>
                @endif
            </div>
            <div class="notif-content">
                <div class="notif-title">{{ $notif->title }}</div>
                <div class="notif-message">{{ $notif->message }}</div>
                <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
            </div>
            @if(!$notif->is_read)
            <div class="notif-action">
                <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="font-size:11px;">
                        Mark Read
                    </button>
                </form>
            </div>
            @endif
        </div>
        @empty
        <div class="text-center py-5 text-muted">
            <i class="fas fa-bell-slash fa-2x d-block mb-2"></i>
            No notifications yet!
        </div>
        @endforelse
    </div>
</div>
{{ $notifications->links() }}
@endsection

@section('scripts')
<style>
    .notif-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
    }
    .notif-item.unread { background: #fafcff; }
    .notif-item.read { background: white; opacity: 0.75; }
    .notif-item:hover { background: #f8fafc; }
    .notif-icon {
        width: 42px; height: 42px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .notif-icon.danger { background: #fff5f5; color: #e74c3c; }
    .notif-icon.warning { background: #fef9e7; color: #e67e22; }
    .notif-icon.info { background: #e8f4fd; color: #2d6a9f; }
    .notif-icon.success { background: #eafaf1; color: #27ae60; }
    .notif-content { flex: 1; }
    .notif-title { font-size: 13px; font-weight: 700; color: #0f2744; margin-bottom: 3px; }
    .notif-message { font-size: 12px; color: #64748b; line-height: 1.5; }
    .notif-time { font-size: 11px; color: #94a3b8; margin-top: 5px; }
    .notif-action { flex-shrink: 0; }
</style>
@endsection