<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar tabla antes de insertar (opcional)
        // User::truncate();

        // Crear usuarios de prueba
        $users = [
            [
                'cod_us' => 'USR001',
                'nom_us' => 'Ithan',
                'ape_us' => 'Escobar',
                'ema_us' => 'ithan@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '79865412',
                'ciu_us' => 'Lima',
                'estado' => 'activo',
                'is_admin' => false,
            ],
            [
                'cod_us' => 'USR002',
                'nom_us' => 'Glenda',
                'ape_us' => 'Supap',
                'ema_us' => 'glenda@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '78945612',
                'ciu_us' => 'La paz',
                'estado' => 'activo',
                'is_admin' => false,
            ],
            [
                'cod_us' => 'USR003',
                'nom_us' => 'Carlos',
                'ape_us' => 'Meave',
                'ema_us' => 'carlos@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '73216548',
                'ciu_us' => 'La paz',
                'estado' => 'activo',
                'is_admin' => false,
            ],
            
        ];

        // Insertar usuarios
        foreach ($users as $user) {
            User::create($user);
        }

        // O también puedes usar: User::insert($users);
    }
}