<div class="card card-body border-0 shadow mb-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <h2 class="h4">Reportes</h2>
        <a href="{{ url('/users') }}" class="btn btn-sm btn-gray-800">Ver Usuarios</a>
    </div>

    <div class="row mb-3 align-items-end">
        <div class="col-md-2">
            <label for="fechaInicio">Fecha Inicio</label>
            <input type="date" wire:model="fechaInicio" class="form-control" id="fechaInicio">
        </div>
        <div class="col-md-2">
            <label for="fechaFin">Fecha Final</label>
            <input type="date" wire:model="fechaFin" class="form-control" id="fechaFin">
        </div>
        <div class="col-md-2">
            <label for="usuarioId">Usuario</label>
            <select wire:model="usuarioId" class="form-control" id="usuarioId" wire:change="filterReports">
                <option value="">Todos</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->first_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="auditorioId">Auditorio</label>
            <select wire:model="auditorioId" class="form-control" id="auditorioId" wire:change="filterReports">
                <option value="">Todos</option>
                @foreach ($auditorios as $auditorio)
                    <option value="{{ $auditorio->id_auditorio }}">{{ $auditorio->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="estado">Estado</label>
            <select wire:model="estado" class="form-control" id="estado" wire:change="filterReports">
                <option value="">Todos</option>
                <option value="aprobado">Aprobado</option>
                <option value="rechazado">Rechazado</option>
                <option value="pendiente">Pendiente</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="actividad">Actividad</label>
            <input type="text" wire:model="actividad" class="form-control" id="actividad"
                placeholder="Buscar actividad" wire:change="filterReports">
        </div>
    </div>
    <div class="d-flex justify-content-end mb-3">
        <button wire:click="filterReports" class="btn btn-primary">Filtrar Reportes</button>
    </div>

    <div class="card card-body border-0 shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @if ($reportes->isEmpty())
                    <p>No hay solicitudes para el rango de fechas seleccionado.</p>
                @else
                    <div class="mb-3">
                        <button wire:click="exportToPdf" class="btn btn-primary">Exportar a PDF</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="reportesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Unidad</th>
                                    <th>Dirección</th>
                                    <th>Auditorio</th>
                                    <th>Nombre Equipo</th>
                                    <th>Código Equipo</th>
                                    <th>Fecha de Uso</th>
                                    <th>Hora Inicio</th>
                                    <th>Hora Final</th>
                                    <th>Actividad</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reportes as $solicitud)
                                    <tr>
                                        <td>{{ $solicitud->id_solicitud }}</td>
                                        <td>{{ $solicitud->user->first_name ?? 'N/A' }}</td>
                                        <td>{{ $solicitud->user->unidad ?? 'N/A' }}</td>
                                        <td>{{ $solicitud->user->address ?? 'N/A' }}</td>
                                        <td>{{ $solicitud->auditorio->nombre ?? 'N/A' }}</td>
                                        <td>
                                            @foreach ($solicitud->equipos as $equipo)
                                                {{ $equipo->nombre }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($solicitud->equipos as $equipo)
                                                {{ $equipo->codigo }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ $solicitud->fecha_uso }}</td>
                                        <td>{{ $solicitud->hora_inicio }}</td>
                                        <td>{{ $solicitud->hora_final }}</td>
                                        <td>{{ $solicitud->actividad }}</td>
                                        <td>{{ $solicitud->estado }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#reportesTable').DataTable();
    });
</script>
