<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si hay usuario autenticado
        if (!Auth::check()) {
            return redirect('/admin/login');
        }

        // Verificar si es administrador
        if (Auth::user()->is_admin != true) {
            abort(403, 'Acceso no autorizado. Solo administradores.');
        }

        return $next($request);
    }
}