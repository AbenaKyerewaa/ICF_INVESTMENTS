@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <span class="eyebrow eyebrow-gold">✦ Activity Alerts</span>
            <h1 class="h2 fw-bold mt-2 mb-1" style="color: var(--icf-navy);">Notifications</h1>
            <p class="text-secondary mb-0">Real-time transfer updates, statements, and account security events.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.read-all') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-icf-secondary">Mark all as read</button>
                </form>
            @endif
        </div>
    </div>

    <div class="surface-card p-3 mb-4 d-flex justify-content-between align-items-center">
        <ul class="nav nav-pills gap-2">
            <li class="nav-item">
                <a class="nav-link {{ $status !== 'unread' ? 'active' : '' }}" href="{{ route('notifications.index') }}" style="{{ $status !== 'unread' ? 'background: var(--icf-blue); color: white;' : 'color: var(--icf-ink);' }}">
                    All notifications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $status === 'unread' ? 'active' : '' }}" href="{{ route('notifications.index', ['status' => 'unread']) }}" style="{{ $status === 'unread' ? 'background: var(--icf-blue); color: white;' : 'color: var(--icf-ink);' }}">
                    Unread @if($unreadCount > 0) <span class="badge bg-danger ms-1">{{ $unreadCount }}</span> @endif
                </a>
            </li>
        </ul>
    </div>

    <div class="surface-card p-0 overflow-hidden">
        @forelse($notifications as $notification)
            <div class="p-4 border-bottom d-flex align-items-start gap-3 {{ $notification->read_at ? '' : 'bg-light' }}">
                <div class="feature-icon flex-shrink-0" style="width: 2.5rem; height: 2.5rem;">
                    @if(str_contains($notification->type, 'failed'))
                        <svg width="16" height="16" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    @elseif(str_contains($notification->type, 'transfer'))
                        <svg width="16" height="16" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    @elseif(str_contains($notification->type, 'security'))
                        <svg width="16" height="16" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    @else
                        <svg width="16" height="16" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    @endif
                </div>
                <div class="flex-grow-1 min-w-0">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-1">
                        <h2 class="h6 fw-bold mb-0 {{ $notification->read_at ? 'text-dark' : 'text-primary' }}">
                            {{ $notification->title }}
                            @if(! $notification->read_at)
                                <span class="badge bg-primary ms-2" style="font-size: .65rem;">New</span>
                            @endif
                        </h2>
                        <span class="small text-secondary">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-secondary small mb-2">{{ $notification->message }}</p>
                    @if(!empty($notification->data))
                        <div class="small bg-white p-2 rounded border font-monospace text-muted mb-2" style="font-size: 0.78rem;">
                            @foreach($notification->data as $key => $val)
                                <span class="me-3"><strong>{{ $key }}:</strong> {{ is_array($val) ? json_encode($val) : $val }}</span>
                            @endforeach
                        </div>
                    @endif
                    <div class="d-flex gap-2">
                        @if(! $notification->read_at)
                            <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-link p-0 text-decoration-none" style="font-size: .8rem; color: var(--icf-blue);">Mark as read</button>
                            </form>
                            <span class="text-muted" style="font-size: .8rem;">•</span>
                        @endif
                        <form method="POST" action="{{ route('notifications.destroy', $notification) }}" onsubmit="return confirm('Delete this notification?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-link p-0 text-danger text-decoration-none" style="font-size: .8rem;">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <div class="feature-icon mx-auto mb-3" style="width: 3.5rem; height: 3.5rem;">
                    <svg width="22" height="22" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                </div>
                <h2 class="h5 fw-bold">All caught up!</h2>
                <p class="text-secondary small mb-0">You have no {{ $status === 'unread' ? 'unread' : '' }} notifications at this time.</p>
            </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
