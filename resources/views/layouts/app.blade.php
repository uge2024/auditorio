<x-layouts.base>
    @php
        $userType = auth()->check() ? auth()->user()->tipo_usuario : null;
    @endphp

    @if (in_array(request()->route()->getName(), [
            'dashboard',
            'profile',
            'calendar',
            'calendar-user',
            'create-solicitud',
            'create-solicitud-user',
            'users',
            'equipos',
            'reportes',
            'auditorio-component',
            'inactivo',
            'notifications',
        ]))
        {{-- Nav --}}
        @include('layouts.nav')

        {{-- SideNav --}}
        @if ($userType === 'admin')
            @include('layouts.sidenav-admin')
        @elseif ($userType === 'user')
            @include('layouts.sidenav-user')
        @endif

        <main class="content">
            {{-- TopBar --}}
            @include('layouts.topbar')
            {{ $slot }}
            {{-- Footer --}}
            @include('layouts.footer')
        </main>
    @elseif(in_array(request()->route()->getName(), ['register', 'login', 'forgot-password', 'reset-password']))
        {{ $slot }}
        {{-- Footer --}}
        @include('layouts.footer2')
    @elseif(in_array(request()->route()->getName(), []))
        {{ $slot }}
    @endif
</x-layouts.base>
