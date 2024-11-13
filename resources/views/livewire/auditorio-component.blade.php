<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">Gestión de Auditorios</h2>
            <p class="mb-0">Aquí puedes agregar, editar y gestionar auditorios.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#auditorioModal"
            wire:click="resetModal">Agregar Nuevo Auditorio</button>
    </div>

    @if ($successMessage)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $successMessage }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Modal para Agregar/Editar Auditorio -->
    <div class="modal fade" id="auditorioModal" tabindex="-1" aria-labelledby="auditorioModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="auditorioModalLabel">
                        {{ $editMode ? 'Actualizar Auditorio' : 'Agregar Nuevo Auditorio' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form wire:submit.prevent="submit">
                    <div class="modal-body">
                        <!-- Campos del Formulario -->
                        <div class="form-group mb-3">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" wire:model.defer="nombre" class="form-control">
                            @error('nombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="ubicacion">Ubicación:</label>
                            <input type="text" id="ubicacion" wire:model.defer="ubicacion" class="form-control">
                            @error('ubicacion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="capacidad">Capacidad:</label>
                            <input type="number" id="capacidad" wire:model.defer="capacidad" class="form-control">
                            @error('capacidad')
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            wire:click="resetModal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            {{ $editMode ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Lista de Auditorios -->
    <div class="container">
        <div class="row">
            @foreach ($auditorios as $auditorio)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm rounded-3 text-center">
                        <img src="{{ $auditorio->imagen ? asset('storage/' . $auditorio->imagen) : asset('path/to/default/image.jpg') }}"
                            alt="{{ $auditorio->nombre }}" class="card-img-top"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $auditorio->nombre }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $auditorio->ubicacion }}</h6>
                            <p class="card-text">{{ Str::limit($auditorio->descripcion, 100) }}</p>
                            <div class="mt-3">
                                <button wire:click="edit({{ $auditorio->id_auditorio }})" class="btn btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#auditorioModal">Editar</button>
                                <button wire:click="delete({{ $auditorio->id_auditorio }})"
                                    class="btn btn-sm btn-outline-gray-600">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        window.addEventListener('notify-success', () => {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                }, 3000);
            }
        });

        window.addEventListener('close-modal', () => {
            const modal = new bootstrap.Modal(document.getElementById('auditorioModal'));
            modal.hide();
        });
    </script>
</div>
