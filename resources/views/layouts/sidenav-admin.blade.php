<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-2 pt-3">
        <!-- User Card for Mobile View -->
        <div
            class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
            <div class="d-flex align-items-center">
                <div class="avatar-lg me-4">
                    <img src="{{ auth()->user()->avatar ?? '/assets/img/team/profile-picture-1.jpg' }}"
                        class="card-img-top rounded-circle border-white" alt="User Avatar">
                </div>
                <div class="d-block">

                    <a class="dropdown-item d-flex align-items-center">
                        <livewire:logout />
                    </a>
                </div>
            </div>
            <div class="collapse-close d-md-none">
                <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
                    aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Sidebar Navigation -->
        <ul class="nav flex-column pt-3 pt-md-0">
            <!-- Dashboard Link -->
            <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center">
                    <span class="sidebar-icon me-3">
                        <img alt="Image placeholder" src="/assets/img/team/profile-picture-1.jpg"
                            class="avatar-md rounded">
                    </span>
                    <span class="mt-1 ms-1 sidebar-text">Sistema De Auditorio</span>
                </a>
            </li>

            <!-- Dashboard Item -->
            <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <span class="sidebar-icon">
                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                    </span>
                    <span class="sidebar-text">Inicio </span>
                </a>
            </li>

            <!-- User Menu -->
            <li class="nav-item">
                <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" data-bs-target="#submenu-user" aria-expanded="true">
                    <span>
                        <span class="sidebar-icon"><i class="fas fa-user me-2" style="color: #fb503b;"></i></span>
                        <span class="sidebar-text" style="color: #fb503b;">Usuario</span>
                    </span>
                    <span class="link-arrow">
                        <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                </span>
                <div class="multi-level collapse {{ request()->is('profile') || request()->is('users') ? 'show' : '' }}"
                    role="list" id="submenu-user" aria-expanded="false">
                    <ul class="flex-column nav">
                        <li class="nav-item {{ request()->is('profile') ? 'active' : '' }}">
                            <a href="{{ route('profile') }}" class="nav-link">
                                <span class="sidebar-text">Perfil de usuario</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->is('users') ? 'active' : '' }}">
                            <a href="{{ route('users') }}" class="nav-link">
                                <span class="sidebar-text">Lista de usuarios</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Calendar Link -->
            <li class="nav-item {{ request()->is('calendar') ? 'active' : '' }}">
                <a href="{{ route('calendar') }}" class="nav-link">
                    <span class="sidebar-icon">
                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                            <path fill-rule="evenodd"
                                d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <span class="sidebar-text">Calendario</span>
                </a>
            </li>

            <!-- Solicitudes Link -->
            <li class="nav-item {{ request()->is('create-solicitud') ? 'active' : '' }}">
                <a href="{{ route('create-solicitud') }}" class="nav-link">
                    <span class="sidebar-icon">
                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                            <path fill-rule="evenodd"
                                d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <span class="sidebar-text">Solicitudes</span>
                </a>
            </li>

            <!-- Auditorio Link -->
            <li class="nav-item {{ request()->is('auditorio-component') ? 'active' : '' }}">
                <a href="{{ route('auditorio-component') }}" class="nav-link">
                    <span class="sidebar-icon">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M5 10h14M5 15h14M5 20h14M4 4v16M20 4v16"></path>
                        </svg>
                    </span>
                    <span class="sidebar-text">Auditorio</span>
                </a>
            </li>

            <!-- Equipos Link -->
            <li class="nav-item {{ request()->is('equipos') ? 'active' : '' }}">
                <a href="{{ route('equipos') }}" class="nav-link d-flex justify-content-between">
                    <span>
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M12 4a3 3 0 00-3 3v4a3 3 0 006 0V7a3 3 0 00-3-3zM6 12a6 6 0 0012 0v3a6 6 0 01-12 0v-3z">
                            </path>
                        </svg>
                        <span class="ms-4">Equipos</span>
                    </span>
                    <span><span class="badge badge-sm bg-secondary ms-1">2</span></span>
                </a>
            </li>

            <!-- Reports Link -->
            <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
            <li class="nav-item {{ request()->is('reportes') ? 'active' : '' }}">
                <a href="{{ route('reportes') }}" class="nav-link d-flex justify-content-between align-items-center">
                    <span class="d-flex align-items-center">
                        <svg class="icon icon-xxs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span>Reportes</span>
                    </span>
                    <span><span class="badge badge-sm bg-secondary ms-1">2</span></span>
                </a>
            </li>

    </div>
</nav>
