<div>
    <!-- Encabezado y barra de herramientas -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lista de usuarios</li>
                </ol>
            </nav>
            <h2 class="h4">Lista de usuarios</h2>
            <p class="mb-0">Gestión de usuarios de la plataforma.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="#" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center"
                wire:click="openCreateUserModal">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nuevo usuario
            </a>
            <div class="btn-group ms-2 ms-lg-3">
                <button type="button" class="btn btn-sm btn-outline-gray-600">Compartir</button>
                <button type="button" class="btn btn-sm btn-outline-gray-600">Exportar</button>
            </div>
        </div>
    </div>

    <!-- Filtros y opciones de visualización -->
    <div class="table-settings mb-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-9 col-lg-8 d-md-flex">
                <div class="input-group me-2 me-lg-3 fmxw-300">
                    <span class="input-group-text">
                        <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <input type="text" class="form-control" placeholder="Buscar usuarios" wire:model="search">
                </div>
                <select class="form-select fmxw-200 d-none d-md-inline" aria-label="Filtrar por estado"
                    wire:model="filterStatus">
                    <option value="">Todos</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive scrollbar">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="text-center">{{ $user->id }}</td>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->tipo_usuario }}</td>
                                <td>{{ $user->estatus }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-gray-600"
                                        wire:click="openEditUserModal({{ $user->id }})">Editar</button>

                                    <button class="btn btn-sm btn-outline-gray-600" type="button"
                                        wire:click="deleteUser({{ $user->id }})">Eliminar</button>
                                    @if ($user->estatus === 'activo')
                                        <button class="btn btn-sm btn-outline-gray-600"
                                            wire:click="changeStatus({{ $user->id }}, 'inactivo')">Desactivar</button>
                                    @else
                                        <button class="btn btn-sm btn-success"
                                            wire:click="changeStatus({{ $user->id }}, 'activo')">Activar</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay usuarios disponibles.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Modal para Crear/Editar Usuario -->
    <div class="modal fade @if ($isUserModalOpen) show @endif" tabindex="-1" role="dialog"
        style="display: @if ($isUserModalOpen) block; @else none; @endif;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $userId ? 'Editar Usuario' : 'Crear Usuario' }}</h5>
                    <button type="button" class="btn-close" wire:click="$set('isUserModalOpen', false)"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="first_name" wire:model.defer="first_name">
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="last_name" wire:model.defer="last_name">
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" wire:model.defer="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" wire:model.defer="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                            <select class="form-select" id="tipo_usuario" wire:model.defer="tipo_usuario">
                                <option value="admin">Administrador</option>
                                <option value="user">Usuario</option>
                            </select>
                            @error('tipo_usuario')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="estatus" class="form-label">Estado</label>
                            <select class="form-select" id="estatus" wire:model.defer="estatus">
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                            @error('estatus')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ci" class="form-label">C.I.</label>
                            <input type="text" class="form-control" id="ci" wire:model.defer="ci">
                            @error('ci')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        wire:click="$set('isUserModalOpen', false)">Cerrar</button>
                    <button type="button" class="btn btn-primary"
                        wire:click="{{ $userId ? 'updateUser' : 'createUser' }}">
                        {{ $userId ? 'Actualizar' : 'Crear' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
