<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class FilamentCustomAuthProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Personalizar la consulta de login de Filament
        config([
            'filament.auth.guard' => 'web',
        ]);
    }

    public function register(): void
    {
        //
    }
}