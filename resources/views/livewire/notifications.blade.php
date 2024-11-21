<div class="list-group list-group-flush">
    <a href="#" class="text-center text-primary fw-bold border-bottom border-light py-3">Notificaciones</a>
    @forelse($notifications as $notification)
        <a href="#" class="list-group-item list-group-item-action border-bottom"
            wire:click.prevent="markAsRead({{ $notification->id }})">
            <div class="row align-items-center">
                <div class="col-auto">
                    <!-- Avatar Placeholder -->
                    <img alt="Image placeholder" src="/assets/img/team/profile-picture-1.jpg" class="avatar-md rounded">
                </div>
                <div class="col ps-0 ms-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="h6 mb-0 text-small">{{ $notification->message }}</h4>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @empty
        <a href="#" class="list-group-item list-group-item-action border-bottom">
            <div class="text-center text-muted">
                No tienes notificaciones nuevas.
            </div>
        </a>
    @endforelse
    <a href="/notifications" class="dropdown-item text-center fw-bold rounded-bottom py-3">Ver todas</a>
</div>
