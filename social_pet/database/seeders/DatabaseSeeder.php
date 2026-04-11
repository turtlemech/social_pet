<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Crear usuario admin (el código se genera automáticamente con trigger)
        User::create([
            'nom_us' => 'Administrador',
            'ema_us' => 'admin@redmascotas.com',
            'pas_us' => Hash::make('12345678'),
            'tel_us' => '123456789',
            'ciu_us' => 'Madrid'
        ]);

        // Crear usuarios de prueba
        User::create([
            'nom_us' => 'Juan Pérez',
            'ema_us' => 'juan@email.com',
            'pas_us' => Hash::make('12345678'),
            'tel_us' => '987654321',
            'ciu_us' => 'Barcelona'
        ]);

        User::create([
            'nom_us' => 'María García',
            'ema_us' => 'maria@email.com',
            'pas_us' => Hash::make('12345678'),
            'tel_us' => '555555555',
            'ciu_us' => 'Valencia'
        ]);

        User::create([
            'nom_us' => 'Carlos López',
            'ema_us' => 'carlos@email.com',
            'pas_us' => Hash::make('12345678'),
            'tel_us' => '444444444',
            'ciu_us' => 'Sevilla'
        ]);
    }
}