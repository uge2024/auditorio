<div class="card card-body border-0 shadow mb-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center py-4">
        <div>
            <nav aria-label="breadcrumb">
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
            <p class="mb-0">Puedes crear nuevas solicitudes para auditorios y gestionar tus solicitudes aquí.</p>
        </div>
        <div>
            <a href="/calendar-user" class="btn btn-sm btn-gray-800">Volver al Calendario</a>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-12 col-md-8">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form wire:submit.prevent="submit">
                <div class="card mb-4 p-4">
                    <div class="card-body">
                        <!-- Auditorium Selection -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="id_auditorio">Auditorio:</label>
                                <select id="id_auditorio" wire:model="solicitud.id_auditorio" class="form-control">
                                    <option value="">Seleccione un auditorio</option>
                                    @foreach ($auditorios as $auditorio)
                                        <option value="{{ $auditorio->id_auditorio }}">{{ $auditorio->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('solicitud.id_auditorio')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Date of Use -->
                            <div class="col-md-6">
                                <label for="fecha_uso">Fecha de Uso:</label>
                                <input type="date" id="fecha_uso" wire:model="solicitud.fecha_uso"
                                    class="form-control">
                                @error('solicitud.fecha_uso')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="card mb-4 p-4">
                            <!-- The button is enabled only when both auditorio and fecha_uso are selected -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#eventModal" @if (empty($solicitud['id_auditorio']) || empty($solicitud['fecha_uso'])) disabled @endif>
                                Ver Solicitudes para la Fecha Seleccionada
                            </button>
                        </div>

                        <!-- Time Selection -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hora_inicio">Hora de Inicio:</label>
                                    <select id="hora_inicio" wire:model="solicitud.hora_inicio" class="form-control">
                                        <option value="">Selecciona una hora</option>
                                        <option value="08:00">08:00</option>
                                        <option value="08:30">08:30</option>
                                        <option value="09:00">09:00</option>
                                        <option value="09:30">09:30</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:30">10:30</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:30">11:30</option>
                                        <option value="12:00">12:00</option>
                                        <option value="">_______________________________________</option>
                                        <option value="14:30">14:30</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:30">15:30</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:30">16:30</option>
                                        <option value="17:00">17:00</option>
                                        <option value="17:30">17:30</option>
                                        <option value="18:00">18:00</option>
                                    </select>
                                    @error('solicitud.hora_inicio')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hora_final">Hora Final:</label>
                                    <select id="hora_final" wire:model="solicitud.hora_final" class="form-control">
                                        <option value="">Selecciona una hora</option>
                                        <option value="08:30">08:30</option>
                                        <option value="09:00">09:00</option>
                                        <option value="09:30">09:30</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:30">10:30</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:30">11:30</option>
                                        <option value="12:00">12:00</option>
                                        <option value="">_______________________________________</option>
                                        <option value="14:30">14:30</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:30">15:30</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:30">16:30</option>
                                        <option value="17:00">17:00</option>
                                        <option value="17:30">17:30</option>
                                        <option value="18:00">18:00</option>
                                        <option value="18:30">18:30</option>
                                    </select>
                                    @error('solicitud.hora_final')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Activity -->
                        <div class="form-group mb-3">
                            <label for="actividad">Actividad:</label>
                            <input type="text" id="actividad" wire:model="solicitud.actividad"
                                class="form-control">
                            @error('solicitud.actividad')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Equipment -->
                        <div class="form-group mb-3">
                            <label for="equipos">Equipos:</label>
                            <div id="equipos">
                                @foreach ($filteredEquipos as $equipo)
                                    <div class="form-check">
                                        <input type="checkbox" id="equipo{{ $equipo->id_equipo }}"
                                            value="{{ $equipo->id_equipo }}" wire:model="selectedEquipos"
                                            class="form-check-input">
                                        <label for="equipo{{ $equipo->id_equipo }}" class="form-check-label">
                                            {{ $equipo->nombre }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('selectedEquipos')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">
                            {{ $editMode ? 'Actualizar Solicitud' : 'Guardar Solicitud' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Eventos de la Fecha Seleccionada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6>Fecha seleccionada: <span>{{ $solicitud['fecha_uso'] }}</span></h6>
                    </div>
                    <div class="events-container">
                        @forelse ($solicitudesPorFecha as $solicitud)
                            <div wire:key="solicitud-{{ $solicitud['id_solicitud'] }}" class="event-block"
                                style="background-color: {{ $solicitud['estado'] == 'aprobado' ? 'green' : 'yellow' }}; margin-bottom: 10px; padding: 10px;">
                                <strong>User: </strong>{{ $solicitud['user']['first_name'] }}<br>
                                <strong>Auditorio: </strong>{{ $solicitud['auditorio']['nombre'] }}<br>
                                <strong>Estado: </strong>{{ ucfirst($solicitud['estado']) }}<br>
                                <strong>Fecha de Solicitud:
                                </strong>{{ \Carbon\Carbon::parse($solicitud['fecha_uso'])->format('d/m/Y') }}<br>
                                <strong>Hora de Inicio:
                                </strong>{{ \Carbon\Carbon::parse($solicitud['hora_inicio'])->format('H:i') }}<br>
                                <strong>Hora de Fin:
                                </strong>{{ \Carbon\Carbon::parse($solicitud['hora_final'])->format('H:i') }}
                            </div>
                        @empty
                            <div class="text-center">No hay solicitudes para esta fecha.</div>
                        @endforelse
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para abrir el modal -->
    <script>
        window.addEventListener('show-modal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('solicitudModal'), {
                keyboard: false
            });
            myModal.show();
        });
    </script>



    <!-- User's Requests Table -->
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <h2 class="mt-4">Mis Solicitudes</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Auditorio</th>
                    <th>Fecha de Uso</th>
                    <th>Hora Inicio</th>
                    <th>Hora Final</th>
                    <th>Actividad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($solicitudesDelUsuario as $solicitud)
                    <tr>
                        <td>{{ $solicitud->id_solicitud }}</td>
                        <td>{{ $solicitud->auditorio->nombre }}</td>
                        <td>{{ $solicitud->fecha_uso }}</td>
                        <td>{{ $solicitud->hora_inicio }}</td>
                        <td>{{ $solicitud->hora_final }}</td>
                        <td>{{ $solicitud->actividad }}</td>
                        <td>{{ ucfirst($solicitud->estado) }}</td>
                        <td>
                            <button wire:click="edit({{ $solicitud->id_solicitud }})"
                                class="btn btn-sm btn-outline-gray-600">Editar</button>
                            <button wire:click="cancel({{ $solicitud->id_solicitud }})"
                                class="btn btn-sm btn-outline-gray-600">Cancelar</button>
                            <!-- Botón para ver la solicitud -->
                            <button wire:click="viewSolicitud({{ $solicitud->id_solicitud }})"
                                class="btn btn-sm btn-outline-gray-600">
                                Ver Información
                            </button>



                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No tienes solicitudes disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div wire:ignore.self class="modal fade" id="solicitudModal" tabindex="-1"
        aria-labelledby="solicitudModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="solicitudModalLabel">Detalles de la Solicitud</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="closeSolicitudModal()"></button>
                </div>
                <div class="modal-body">
                    @if ($selectedSolicitud)
                        <div class="container-fluid">
                            <!-- Usuario y Auditorio -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="border p-4 rounded shadow-sm bg-light">
                                        <h6 class="text-muted">Información del Usuario</h6>
                                        <p class="mb-1"><strong>Nombre:</strong>
                                            {{ $selectedSolicitud->user->first_name }}
                                            {{ $selectedSolicitud->user->last_name }}</p>
                                        <p class="mb-0"><strong>Email:</strong>
                                            {{ $selectedSolicitud->user->email }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-4 rounded shadow-sm bg-light">
                                        <h6 class="text-muted">Detalles del Auditorio</h6>
                                        <p class="mb-1"><strong>Nombre:</strong>
                                            {{ $selectedSolicitud->auditorio->nombre }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Fechas y Horarios -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="border p-4 rounded shadow-sm bg-light">
                                        <h6 class="text-muted">Fecha de Uso</h6>
                                        <p class="mb-1"><strong>Fecha:</strong> {{ $selectedSolicitud->fecha_uso }}
                                        </p>
                                        <p class="mb-0"><strong>Fecha de Solicitud:</strong>
                                            {{ $selectedSolicitud->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-4 rounded shadow-sm bg-light">
                                        <h6 class="text-muted">Horario</h6>
                                        <p class="mb-1"><strong>Hora de Inicio:</strong>
                                            {{ $selectedSolicitud->hora_inicio }}</p>
                                        <p class="mb-0"><strong>Hora de Finalización:</strong>
                                            {{ $selectedSolicitud->hora_final }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Equipos -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="border p-4 rounded shadow-sm bg-light">
                                        <h6 class="text-muted">Equipos Solicitados</h6>
                                        <ul class="list-group list-group-flush">
                                            @foreach ($selectedSolicitud->equipos as $equipo)
                                                <li class="list-group-item">{{ $equipo->nombre }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Actividad -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="border p-4 rounded shadow-sm bg-light">
                                        <h6 class="text-muted">Descripción de la Actividad</h6>
                                        <p>{{ $selectedSolicitud->actividad }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-center text-muted">No hay detalles disponibles para esta solicitud.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        onclick="closeSolicitudModal()">Cerrar</button>
                    @if ($selectedSolicitud)
                        <button type="button" class="btn btn-primary"
                            wire:click="exportToPDF({{ $selectedSolicitud->id_solicitud }})">
                            Exportar a PDF
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('show-modal', event => {
            const myModal = new bootstrap.Modal(document.getElementById('solicitudModal'), {
                keyboard: false
            });
            myModal.show();
        });

        function closeSolicitudModal() {
            const myModalEl = document.getElementById('solicitudModal');
            const modal = bootstrap.Modal.getInstance(myModalEl);

            if (modal) {
                modal.hide();
            }

            // Eliminar manualmente el backdrop si persiste
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        }
    </script>




</div>
