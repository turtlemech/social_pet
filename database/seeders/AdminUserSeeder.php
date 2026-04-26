<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar si ya existe el admin
        $admin = User::where('ema_us', 'admin@admin.com')->first();
        
        if (!$admin) {
            User::create([
                'cod_us' => 'ADMIN001',
                'nom_us' => 'Administrador',
                'ape_us' => 'Principal',           
                'ema_us' => 'admin@admin.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '123456789',
                'ciu_us' => 'La paz',                 
                'estado' => 'activo',               
                'is_admin' => true,
            ]);
            
            $this->command->info('✓ Usuario administrador creado exitosamente');
            $this->command->info('  Email: admin@admin.com');
            $this->command->info('  Contraseña: 12345678');
        } else {
            $this->command->info('⚠ El usuario administrador ya existe');
        }
    }
}