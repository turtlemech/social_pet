<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
                'ema_us' => 'admin@admin.com',
                'pas_us' => bcrypt('12345678'),
                'tel_us' => '123456789',
                'is_admin' => true,
            ]);
            
            $this->command->info('Usuario administrador creado exitosamente');
        } else {
            $this->command->info('El usuario administrador ya existe');
        }
    }
}
