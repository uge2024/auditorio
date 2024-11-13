<main>
    <title> Panel - Olvidé mi contraseña</title>
    <!-- Sección -->
    <section class="vh-lg-100 mt-4 mt-lg-0 bg-soft d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center form-bg-image">
                <p class="text-center"><a href="{{ route('login') }}"
                        class="d-flex align-items-center justify-content-center"><svg class="icon icon-xs me-2"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                clip-rule="evenodd"></path>
                        </svg> Volver al inicio de sesión</a></p>
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="signin-inner my-3 my-lg-0 bg-white shadow border-0 rounded p-4 p-lg-5 w-100 fmxw-500">
                        <h1 class="h3">¿Olvidaste tu contraseña?</h1>
                        <p class="mb-4">¡No te preocupes! Solo ingresa tu correo electrónico y te enviaremos un código para restablecer tu contraseña.</p>
                        <form wire:submit.prevent="recoverPassword" action="#" method="POST">
                            <!-- Formulario -->
                            <div class="mb-4">
                                <label for="email">Tu Correo Electrónico</label>
                                <div class="input-group">
                                    <input wire:model='email' type="email" class="form-control" id="email"
                                        placeholder="john@company.com" required autofocus>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Fin del Formulario -->
                            @if ($mailSentAlert)
                                <div class="alert alert-success" role="alert">
                                    Se ha enviado un correo electrónico con el enlace para restablecer la contraseña.
                                </div>
                            @endif
                            @if ($showDemoNotification)
                                <div class="alert alert-danger" role="alert">
                                    No puedes hacer eso en la versión demo.
                                </div>
                            @endif
                            <div class="d-grid">
                                <button type="submit" class="btn btn-gray-800">Recuperar contraseña</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
