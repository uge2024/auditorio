<div>
    <!-- Encabezado y barra de herramientas -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gestión de Equipos</li>
                </ol>
            </nav>
            <h2 class="h4">Gestión de Equipos</h2>
            <p class="mb-0">Aquí puedes agregar, editar y gestionar equipos.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#equipoModal"
            wire:click="resetModal">Agregar Nuevo Equipo</button>
    </div>

    <!-- Mensaje de éxito -->
    @if ($successMessage)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $successMessage }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Modal para agregar/editar equipo -->
    <div class="modal fade" id="equipoModal" tabindex="-1" aria-labelledby="equipoModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="equipoModalLabel">
                        {{ $editMode ? 'Actualizar Equipo' : 'Agregar Nuevo Equipo' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form wire:submit.prevent="submit">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" wire:model.defer="nombre" class="form-control">
                            @error('nombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="codigo">Código:</label>
                            <input type="text" id="codigo" wire:model.defer="codigo" class="form-control">
                            @error('codigo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="descripcion">Descripción:</label>
                            <textarea id="descripcion" wire:model.defer="descripcion" class="form-control"></textarea>
                            @error('descripcion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="imagen">Imagen:</label>
                            <input type="file" id="imagen" wire:model="imagen" class="form-control">
                            <div class="mt-2">
                                @if ($imagen instanceof \Livewire\TemporaryUploadedFile)
                                    <img src="{{ $imagen->temporaryUrl() }}" alt="Vista previa" class="img-thumbnail"
                                        style="max-width: 150px;">
                                @elseif($editMode && $imagen)
                                    <img src="{{ asset('storage/' . $imagen) }}" alt="Imagen actual"
                                        class="img-thumbnail" style="max-width: 150px;">
                                @else
                                    <p>No hay imagen actual.</p>
                                @endif
                            </div>
                            @error('imagen')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_auditorio">Auditorio:</label>
                            <select id="id_auditorio" wire:model.defer="id_auditorio" class="form-control">
                                <option value="">Seleccione un auditorio</option>
                                @foreach ($auditorios as $auditorio)
                                    <option value="{{ $auditorio->id_auditorio }}">{{ $auditorio->nombre }}</option>
                                @endforeach
                            </select>
                            @error('id_auditorio')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            wire:click="resetModal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"
                            wire:loading.attr="disabled">{{ $editMode ? 'Actualizar' : 'Guardar' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Lista de equipos en formato de tarjetas -->
    <div class="container">
        <div class="row">
            @foreach ($equipos as $equipo)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm rounded-3 text-center">
                        <img src="{{ $equipo->imagen ? asset('storage/' . $equipo->imagen) : asset('path/to/default/image.jpg') }}"
                            alt="{{ $equipo->nombre }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $equipo->nombre }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $equipo->codigo }}</h6>
                            <p class="card-text">{{ Str::limit($equipo->descripcion, 100) }}</p>
                            <div class="mt-3">
                                <button wire:click="edit({{ $equipo->id_equipo }})" class="btn btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#equipoModal">Editar</button>
                                <button wire:click="delete({{ $equipo->id_equipo }})"
                                    class="btn btn-sm btn-outline-gray-600">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Script para ocultar mensaje después de 3 segundos y cerrar el modal -->
    <script>
        window.addEventListener('notify-success', () => {
            setTimeout(() => {
                const alert = document.querySelector('.alert-success');
                if (alert) {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                }
            }, 3000);
        });

        window.addEventListener('close-modal', () => {
            const modal = new bootstrap.Modal(document.getElementById('equipoModal'));
            modal.hide();
        });
    </script>
</div>
