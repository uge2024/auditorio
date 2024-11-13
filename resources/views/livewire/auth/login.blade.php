<main>
    <div style="height: 100vh; overflow-y: auto;">
        <!-- Your login content here -->

        <title> Página de Inicio de Sesión</title>
        <!-- Section -->
        <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
            <div class="container">
                {{-- <p class="text-center"><a href="{{ route('dashboard') }}" class="text-gray-700"><i
                class="fas fa-angle-left me-2"></i> </a></p> --}}
                <div wire:ignore.self class="row justify-content-center form-bg-image">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="bg-white shadow-soft border rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                            <div
                                style="display: flex; align-items: center; justify-content: center; text-align: center; margin-bottom: 1rem; margin-top: 0;">
                                <img src="../assets/img/team/profile-picture-1.jpg" alt="Profile Picture"
                                    style="width: 100px; height: 100px; margin-right: 15px; border-radius: 50%;">
                                <h1 style="margin: 0; font-size: 26px;">Bienvenido al Sistema de Solicitud de Auditorio
                                </h1>

                            </div>
                            <form wire:submit.prevent="login" action="#" class="mt-4" method="POST">
                                <!-- Form -->
                                <div class="form-group mb-4">
                                    <label for="email">Tu Correo Electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><svg
                                                class="icon icon-xs text-gray-600" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="#">
                                                <path
                                                    d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                                </path>
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z">
                                                </path>
                                            </svg></span>
                                        <input wire:model="email" type="email" class="form-control"
                                            placeholder="ejemplo@gmail.com" id="email" autofocus required>
                                    </div>
                                    @error('email')
                                        <div wire:key="form" class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <!-- End of Form -->
                                <div class="form-group">
                                    <!-- Form -->
                                    <div class="form-group mb-4">
                                        <label for="password">Tu Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon2"><svg
                                                    class="icon icon-xs text-gray-600" fill="currentColor"
                                                    viewBox="0 0 20 20" xmlns="#">
                                                    <path fill-rule="evenodd"
                                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg></span>
                                            <input wire:model.lazy="password" type="password" placeholder="Password"
                                                class="form-control" id="password" required>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                    <!-- End of Form -->
                                    <div class="d-flex justify-content-between align-items-top mb-4">
                                        <div class="form-check">
                                            <input wire:model="remember_me" class="form-check-input" type="checkbox"
                                                value="" id="remember">
                                            <label class="form-check-label mb-0" for="remember">
                                                Recuérdame
                                            </label>
                                        </div>
                                        <div><a href="{{ route('forgot-password') }}"
                                                class="small text-right">¿Olvidaste
                                                tu contraseña?</a></div>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-gray-800">Ingresar</button>
                                </div>
                            </form>
                            <div class="mt-3 mb-4 text-center">
                                <span class="fw-normal">o inicia sesión con</span>
                            </div>
                            <!-- Button to Open Modal -->
                            <div class="d-flex justify-content-center my-4">
                                @if ($activationError)
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        {{ $activationError }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <div class="mt-2">
                                            <button onclick="openModal()" class="whatsapp-button">Activar
                                                Cuenta</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- Modal Structure -->
                            <div id="whatsappModal" class="modal">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal()">&times;</span>
                                    <h2>Activar Cuenta</h2>

                                    <form id="whatsappForm" onsubmit="sendToWhatsApp(); return false;">
                                        <label for="name"><strong>Nombre:</strong></label>
                                        <input type="text" id="name" placeholder="Escriba su nombre" required>

                                        <label for="unit"><strong>Unidad:</strong></label>
                                        <input type="text" id="unit" placeholder="Escriba su unidad" required>

                                        <label for="address"><strong>Dirección:</strong></label>
                                        <input type="text" id="address" placeholder="Escriba su dirección"
                                            required>

                                        <button type="submit" class="whatsapp-button my-2">Enviar a WhatsApp</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Styles -->
                            <style>
                                /* Button Styling */
                                .whatsapp-button {
                                    background-color: #25D366;
                                    color: white;
                                    padding: 10px 20px;
                                    text-decoration: none;
                                    border: none;
                                    border-radius: 5px;
                                    font-weight: bold;
                                    cursor: pointer;
                                }

                                /* Modal Styling */
                                .modal {
                                    display: none;
                                    position: fixed;
                                    z-index: 1;
                                    left: 0;
                                    top: 0;
                                    width: 100%;
                                    height: 100%;
                                    overflow: auto;
                                    background-color: rgba(0, 0, 0, 0.4);
                                }

                                .alert {
                                    position: relative;
                                    margin: 20px 0;
                                    padding: 15px;
                                    border-radius: 5px;
                                }

                                .whatsapp-button {
                                    background-color: #25D366;
                                    /* WhatsApp green */
                                    color: white;
                                    border: none;
                                    padding: 10px 20px;
                                    border-radius: 5px;
                                    cursor: pointer;
                                }

                                .whatsapp-button:hover {
                                    background-color: #128C7E;
                                    /* Darker green on hover */
                                }

                                .modal-content {
                                    background-color: #fefefe;
                                    margin: 10% auto;
                                    padding: 20px;
                                    border: 1px solid #888;
                                    width: 80%;
                                    max-width: 500px;
                                    border-radius: 8px;
                                }

                                .close {
                                    color: #aaa;
                                    float: right;
                                    font-size: 28px;
                                    font-weight: bold;
                                    cursor: pointer;
                                }

                                .close:hover,
                                .close:focus {
                                    color: #000;
                                    text-decoration: none;
                                    cursor: pointer;
                                }

                                /* Form Styling */
                                #whatsappForm {
                                    display: flex;
                                    flex-direction: column;
                                }

                                #whatsappForm label {
                                    font-weight: bold;
                                    margin-top: 10px;
                                }

                                #whatsappForm input {
                                    padding: 8px;
                                    margin-top: 5px;
                                    border: 1px solid #ddd;
                                    border-radius: 4px;
                                    width: 100%;
                                }
                            </style>

                            <!-- JavaScript -->
                            <script>
                                // Function to open the modal
                                function openModal() {
                                    document.getElementById("whatsappModal").style.display = "block";
                                }

                                // Function to close the modal
                                function closeModal() {
                                    document.getElementById("whatsappModal").style.display = "none";
                                }

                                // Function to send data to WhatsApp
                                // Function to send data to WhatsApp
                                function sendToWhatsApp() {
                                    const name = document.getElementById("name").value;
                                    const unit = document.getElementById("unit").value;
                                    const address = document.getElementById("address").value;
                                    const email = document.getElementById("email").value;

                                    // Construct the message with simulated bold text
                                    const message =
                                        `Hola, me gustaría activar mi cuenta. Mis datos son:\n- Nombre: *${name}*\n- Unidad: *${unit}*\n- Dirección: *${address}*\n- Correo Electrónico: *${email}*`;
                                    const encodedMessage = encodeURIComponent(message);

                                    // Open WhatsApp link
                                    const whatsappUrl = `https://wa.me/64881617?text=${encodedMessage}`;
                                    window.open(whatsappUrl, "_blank");

                                    closeModal();
                                }
                            </script>



                            <div class="d-flex justify-content-center align-items-center mt-4">
                                <span class="fw-normal">
                                    ¿No estás registrado?
                                    <a href="{{ route('register') }}" class="fw-bold">Crea una cuenta</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

</main>

<body style="margin: 0; overflow: hidden; height: 100%; position: relative;">
    <video autoplay muted loop
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;">
        <source src="https://cdn.pixabay.com/video/2016/05/12/3132-166335897_large.mp4" type="video/mp4">
        Tu navegador no soporta el video.
    </video>
</body>
</div>
