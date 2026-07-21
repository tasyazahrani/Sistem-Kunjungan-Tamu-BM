@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Notifikasi</h4>
    <button class="btn btn-sm btn-outline-primary" onclick="markAllAsRead()">
        <i class="bi bi-check2-all me-1"></i> Tandai Semua Dibaca
    </button>
</div>

<div class="card card-stat p-0" id="notificationList">
    @forelse($notifications as $notif)
        <div class="notification-item p-3 border-bottom {{ !$notif->is_read ? 'bg-light' : '' }}" 
             data-id="{{ $notif->id }}">
            <div class="d-flex align-items-start gap-3">
                <div class="notification-icon mt-1">
                    <i class="bi {{ $notif->icon }} text-{{ $notif->color }} fs-4"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1 {{ !$notif->is_read ? 'fw-bold' : '' }}">
                                {{ $notif->title }}
                            </h6>
                            <p class="text-muted small mb-1">{{ $notif->message }}</p>
                            @if($notif->link)
                                <a href="{{ $notif->link }}" class="small text-primary">Lihat detail</a>
                            @endif
                            <small class="text-muted d-block mt-1">
                                {{ $notif->created_at->diffForHumans() }}
                            </small>
                        </div>
                        @if(!$notif->is_read)
                            <button class="btn btn-sm btn-outline-secondary mark-read-btn" 
                                    data-id="{{ $notif->id }}">
                                <i class="bi bi-check"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
            <p>Belum ada notifikasi</p>
        </div>
    @endforelse
</div>

<div class="mt-3">
    {{ $notifications->links() }}
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark as read
    document.querySelectorAll('.mark-read-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            markAsRead(id);
        });
    });
});

// Fungsi global
function markAsRead(id) {
    fetch(`/api/notifications/${id}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const item = document.querySelector(`.notification-item[data-id="${id}"]`);
            if (item) {
                item.classList.remove('bg-light');
                const title = item.querySelector('h6');
                if (title) title.classList.remove('fw-bold');
                const btn = item.querySelector('.mark-read-btn');
                if (btn) btn.remove();
            }
            updateBadge();
        }
    });
}

function markAllAsRead() {
    if (!confirm('Tandai semua notifikasi sebagai sudah dibaca?')) return;
    
    fetch('/api/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelectorAll('.notification-item').forEach(item => {
                item.classList.remove('bg-light');
                const title = item.querySelector('h6');
                if (title) title.classList.remove('fw-bold');
                const btn = item.querySelector('.mark-read-btn');
                if (btn) btn.remove();
            });
            updateBadge();
            window.location.reload();
        }
    });
}

function updateBadge() {
    fetch('/api/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notifBadge');
            if (badge) {
                badge.textContent = data.count;
                badge.style.display = data.count > 0 ? 'block' : 'none';
            }
        });
}
</script>
@endpush