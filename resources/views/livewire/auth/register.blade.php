<main>
    <div style="height: 100vh; overflow-y: auto;">
        <title>Página de Registro</title>
        <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
            <div class="container">
                <div wire:ignore.self class="row justify-content-center form-bg-image">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="bg-white shadow-soft border rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                            <div class="text-center mb-4">
                                <img src="../assets/img/team/profile-picture-1.jpg" alt="Profile Picture"
                                     style="width: 80px; height: 80px; border-radius: 50%; margin-bottom: 15px;">
                                <h2 class="mb-0">Registro para el Sistema de Solicitud de Auditorio</h2>
                                <p class="text-muted">Complete los campos para crear una cuenta</p>
                            </div>
                            <form wire:submit.prevent="register" method="POST">
                                <div class="row">
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="ci">Cédula de Identidad (CI)</label>
                                        <input wire:model="ci" id="ci" type="text" class="form-control" placeholder="12345678" required>
                                        @error('ci') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="first_name">Nombre</label>
                                        <input wire:model="first_name" id="first_name" type="text" class="form-control" placeholder="Juan" required>
                                        @error('first_name') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="last_name">Apellido</label>
                                        <input wire:model="last_name" id="last_name" type="text" class="form-control" placeholder="Pérez" required>
                                        @error('last_name') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="address">Dirección</label>
                                        <input wire:model="address" id="address" type="text" class="form-control" placeholder="Av. Siempre Viva 742" required>
                                        @error('address') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="number">Número de Teléfono</label>
                                        <input wire:model="number" id="number" type="text" class="form-control" placeholder="77777777" required>
                                        @error('number') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="unidad">Unidad</label>
                                        <input wire:model="unidad" id="unidad" type="text" class="form-control" placeholder="Unidad de Recursos Humanos" required>
                                        @error('unidad') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="email">Correo Electrónico</label>
                                        <input wire:model="email" id="email" type="email" class="form-control" placeholder="ejemplo@gmail.com" required>
                                        @error('email') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="password">Contraseña</label>
                                        <input wire:model.lazy="password" id="password" type="password" class="form-control" placeholder="Contraseña" required>
                                        <small class="form-text text-muted">Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula, y un número.</small>
                                        @error('password') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="confirm_password">Confirmar Contraseña</label>
                                        <input wire:model.lazy="passwordConfirmation" id="confirm_password" type="password" class="form-control" placeholder="Confirmar Contraseña" required>
                                        @error('passwordConfirmation') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                                    </div>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        Acepto los <a href="#">términos y condiciones</a>
                                    </label>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Registrarse</button>
                                </div>
                            </form>
                            <div class="text-center mt-4">
                                <span class="fw-normal">¿Ya tienes una cuenta?</span>
                                <a href="{{ route('login') }}" class="fw-bold">Inicia sesión aquí</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<body style="margin: 0; overflow: hidden; height: 100%; position: relative;">
    <video autoplay muted loop style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;">
        <source src="https://cdn.pixabay.com/video/2016/05/12/3132-166335897_large.mp4" type="video/mp4">
        Tu navegador no soporta el video.
    </video>
</body>
