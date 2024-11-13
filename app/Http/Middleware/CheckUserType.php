<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    public function handle(Request $request, Closure $next, $type)
    {
        if (auth()->check() && auth()->user()->tipo_usuario === $type) {
            return $next($request);
        }

        // Redirige a una página de error personalizada o al inicio
        return redirect('@error')->with('error', 'No tienes permiso para acceder a esta página.');
    }
}

