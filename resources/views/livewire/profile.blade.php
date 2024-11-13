<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div>
            <h2 class="h4 fw-bold text-dark">Perfil de Usuario</h2>
            <p class="text-muted mb-0">Gestiona tu información y conecta con otros.</p>
        </div>
        @if ($isAdmin)
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#usersModal">
                Ver Usuarios
            </button>
        @endif
    </div>

    <!-- Current User Information -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body text-center">
            <img src="{{ asset('assets/img/team/profile-picture-1.jpg') }}" class="avatar-xl rounded-circle border border-4 border-white shadow" alt="User Portrait">
            <h4 class="h3 mt-3 text-dark">{{ $user->first_name ?? 'Nombre del Usuario' }} {{ $user->last_name }}</h4>
            <p class="text-muted mb-2"><strong>Unidad:</strong> {{ $user->unidad ?? 'Unidad no especificada' }}</p>
            <p class="text-muted"><strong>Correo:</strong> {{ $user->email ?? 'Correo no especificado' }}</p>
            <p class="text-muted"><strong>Teléfono:</strong> {{ $user->number ?? 'No especificado' }}
                @if($user->number)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $user->number) }}" target="_blank" class="btn btn-success btn-sm d-inline-flex align-items-center ms-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                            <path d="M13.601 2.326a7.548 7.548 0 00-10.669 0 7.492 7.492 0 00-2.207 5.336c.003 1.226.33 2.43.95 3.485L1 15l3.952-.976a7.558 7.558 0 003.688.961h.001a7.492 7.492 0 005.336-2.208 7.548 7.548 0 000-10.669zm-5.335 12.02h-.001a6.522 6.522 0 01-3.357-.926l-.24-.143-2.947.732.768-2.881-.157-.247a6.465 6.465 0 01-.956-3.005 6.535 6.535 0 011.92-4.646 6.522 6.522 0 014.648-1.922h.002a6.523 6.523 0 014.649 1.922 6.522 6.522 0 011.922 4.648 6.535 6.535 0 01-1.922 4.646 6.522 6.522 0 01-4.648 1.922z"/>
                            <path d="M10.02 8.864c-.15-.075-.887-.438-1.024-.488s-.237-.075-.338.075c-.1.15-.388.488-.475.588-.087.1-.175.113-.325.038-.15-.075-.637-.234-1.213-.748-.45-.4-.752-.9-.838-1.05-.087-.15-.009-.225.066-.3.068-.069.15-.175.225-.262.075-.088.1-.15.15-.25.05-.1.025-.188-.012-.263-.037-.075-.338-.812-.463-1.112-.122-.294-.244-.25-.338-.25h-.288c-.1 0-.262.037-.4.175s-.525.513-.525 1.25.538 1.45.613 1.55c.075.1 1.058 1.625 2.563 2.275.35.15.625.237.838.313.35.112.675.097.938.059.288-.043.887-.362 1.012-.713.125-.35.125-.65.087-.713-.037-.062-.137-.1-.288-.175z"/>
                        </svg>
                    </a>
                @endif
            </p>
        </div>
    </div>

    <!-- Admin View: Modal with All Users -->
    @if ($isAdmin)
    <div class="modal fade" id="usersModal" tabindex="-1" aria-labelledby="usersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="usersModalLabel">Lista de Usuarios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Unidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->number ?? 'No especificado' }}</td>
                                <td>{{ $user->unidad ?? 'Sin Unidad' }}</td>
                                <td>
                                    <a href="mailto:{{ $user->email }}" class="btn btn-sm btn-outline-secondary">Email</a>
                                    @if($user->number)
                                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $user->number) }}" target="_blank" class="btn btn-sm btn-success">WhatsApp</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Regular User View: Admin Contact -->
    @if (!$isAdmin && $admin)
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">
            <h5 class="h5 text-dark">Contactar con el Administrador</h5>
            <p class="text-muted"><strong>Nombre:</strong> {{ $admin->first_name }} {{ $admin->last_name }}</p>
            <p class="text-muted"><strong>Correo:</strong> {{ $admin->email }}</p>
            <p class="text-muted"><strong>Teléfono:</strong> {{ $admin->number ?? 'No especificado' }}
                @if($admin->number)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $admin->number) }}" target="_blank" class="btn btn-success btn-sm d-inline-flex align-items-center ms-2">WhatsApp</a>
                @endif
            </p>
        </div>
    </div>
    @endif
</div>
