<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class Userseeder extends Seeder
{
    public function run(): void
    {
        // Crear usuarios de prueba
        $users = [
            [
                'cod_us' => 'USR001',
                'nom_us' => 'ithan escobar',
                'ema_us' => 'ithan@socialpet.com',
                'pas_us' => bcrypt('12345678'),
                'tel_us' => '987654321',
                'is_admin' => false,
            ],
            [
                'cod_us' => 'USR002',
                'nom_us' => 'glenda supa',
                'ema_us' => 'glenda@socialpet.com',
                'pas_us' => bcrypt('12345678'),
                'tel_us' => '987654322',
                'is_admin' => false,
            ],
            [
                'cod_us' => 'USR003',
                'nom_us' => 'carlos meave',
                'ema_us' => 'carlos@socialpet.com',
                'pas_us' => bcrypt('12345678'),
                'tel_us' => '987654323',
                'is_admin' => false,
            ],
        ];

        foreach ($users as $user) {
            $existing = User::where('ema_us', $user['ema_us'])->first();
            if (!$existing) {
                User::create($user);
            }
        }
        
        $this->command->info('Usuarios normales creados exitosamente');
    }
}
