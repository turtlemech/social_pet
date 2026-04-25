<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class ForceSessionSave
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        // Forzar guardado de sesión al final de cada petición
        if (session()->isStarted()) {
            session()->save();
        }
        
        return $response;
    }
}