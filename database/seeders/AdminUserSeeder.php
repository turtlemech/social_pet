<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar si ya existe el admin por email
        $admin = User::where('ema_us', 'admin@socialpet.com')->first();
        
                User::create([
                'cod_us' => 'ADMIN001',
                'nom_us' => 'Administrador',
                'app_us' => 'Principal',
                'apm_us' => 'Sistema',
                'ema_us' => 'admin@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '789123456',
                'ubi_us' => 'La Paz',
                'tip_us' => 'admin',           // Enum: ['admin', 'soporte', 'usuario']
                'est_us' => 'activo',          // Enum: ['activo', 'inactivo', 'baneado']
                'ava_us' => null,
                'is_admin' => true,
                
            ]);
            
            
    }
}