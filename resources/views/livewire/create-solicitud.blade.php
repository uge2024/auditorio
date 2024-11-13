<div class="card card-body border-0 shadow mb-4">
    <!-- Header and toolbar -->
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
                    <li class="breadcrumb-item active" aria-current="page">Crear Solicitud</li>
                </ol>
            </nav>
            <h2 class="h4">Crear Solicitud</h2>
            <p class="mb-0">Aquí puedes crear nuevas solicitudes para auditorios y gestionar solicitudes.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="/calendar" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Volver al Calendario
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-8">
            <!-- Session messages -->
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search bar -->
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                <input type="text" wire:model="search" placeholder="Buscar por nombre" class="form-control mb-2" />
                <div class="col-md-6">
                <select wire:model="statusFilter" class="form-control mb-2">
                    <option value="">Seleccionar estado</option>
                    <option value="aprobado">Aceptada</option>
                    <option value="rechazado">Rechazada</option>
                    <option value="pendiente">Pendiente</option>
                </select>
            </div>
        </div>
    </div>
</div>

      <!-- Requests table -->
            <div class="card card-body border-0 shadow mb-4">
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Auditorio</th>
                                <th>Fecha de Uso</th>
                                <th>Hora Inicio</th>
                                <th>Hora Final</th>
                                <th>Actividad</th>
                                <th>Estado</th>
                                <th>Usuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($solicitudes as $solicitud)
                                <tr>
                                    <td>{{ $solicitud->id_solicitud }}</td>
                                    <td>{{ $solicitud->auditorio->nombre }}</td>
                                    <td>{{ $solicitud->fecha_uso }}</td>
                                    <td>{{ $solicitud->hora_inicio }}</td>
                                    <td>{{ $solicitud->hora_final }}</td>
                                    <td>{{ $solicitud->actividad }}</td>
                                    <td>{{ ucfirst($solicitud->estado) }}</td>
                                    <td>{{ $solicitud->user->first_name }}</td>
                                    <td>
                                        <button wire:click="edit({{ $solicitud->id_solicitud }})" class="btn btn-sm btn-outline-gray-600">Editar</button>
                                        <button wire:click="delete({{ $solicitud->id_solicitud }})" class="btn btn-sm btn-outline-gray-600">Eliminar</button>
                                        <button wire:click="accept({{ $solicitud->id_solicitud }})" class="btn btn-sm btn-outline-gray-600">Aceptar</button>
                                        <button wire:click="reject({{ $solicitud->id_solicitud }})" class="btn btn-sm btn-outline-gray-600">Rechazar</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No hay solicitudes disponibles.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal for creating and editing requests -->
            <div id="editModal" class="modal" style="display:none;">
                <div class="modal-content" style="width: 400px; margin: auto; padding: 20px;">
                    <span class="close" wire:click="$set('editMode', false); resetForm();">&times;</span>
                    <h2 class="h5">{{ $editMode ? 'Editar Solicitud' : 'Crear Solicitud' }}</h2>
                    <form wire:submit.prevent="submit">
                        <div class="mb-2">
                            <label for="id_auditorio">Auditorio:</label>
                            <select wire:model="solicitud.id_auditorio" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach ($auditorios as $auditorio)
                                    <option value="{{ $auditorio->id_auditorio }}">{{ $auditorio->nombre }}</option>
                                @endforeach
                            </select>
                            @error('solicitud.id_auditorio') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-2">
                            <label for="fecha_uso">Fecha:</label>
                            <input type="date" wire:model="solicitud.fecha_uso" class="form-control">
                            @error('solicitud.fecha_uso') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-2">
                            <label for="hora_inicio">Hora Inicio:</label>
                            <select wire:model="solicitud.hora_inicio" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach ($horasPermitidas as $hora)
                                    <option value="{{ $hora }}">{{ $hora }}</option>
                                @endforeach
                            </select>
                            @error('solicitud.hora_inicio') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-2">
                            <label for="hora_final">Hora Final:</label>
                            <select wire:model="solicitud.hora_final" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach ($horasPermitidas as $hora)
                                    <option value="{{ $hora }}">{{ $hora }}</option>
                                @endforeach
                            </select>
                            @error('solicitud.hora_final') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-2">
                            <label for="actividad">Actividad:</label>
                            <input type="text" wire:model="solicitud.actividad" class="form-control">
                            @error('solicitud.actividad') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">{{ $editMode ? 'Actualizar' : 'Crear' }}</button>
                    </form>
                </div>
            </div>

            <script>
                window.addEventListener('openEditModal', event => {
                    document.getElementById('editModal').style.display = 'block';
                });

                document.querySelector('.close').onclick = function() {
                    document.getElementById('editModal').style.display = 'none';
                };

                window.onclick = function(event) {
                    if (event.target === document.getElementById('editModal')) {
                        document.getElementById('editModal').style.display = 'none';
                    }
                };
            </script>
        </div>
    </div>
</div>
