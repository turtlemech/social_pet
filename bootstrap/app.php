<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\ForceSessionSave;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Agregar middleware al grupo web (se ejecuta en todas las rutas web)
        $middleware->web(append: [
            ForceSessionSave::class,
        ]);
        
        // Registrar middleware con alias
        $middleware->alias([
            'admin' => Authenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();