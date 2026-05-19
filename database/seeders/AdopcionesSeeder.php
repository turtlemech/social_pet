<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdopcionesSeeder extends Seeder
{
    public function run(): void
    {
        $estados = ['pendiente', 'aprobada', 'rechazada'];
        
        for ($i = 1; $i <= 50; $i++) {
            $mas_id = rand(1, 50);
            $us_act = rand(1, 50); // Usuario activo que publica la adopción
            $us_sol = rand(1, 60); // Solicitante (puede ser soporte también)
            
            DB::table('adopciones')->insert([
                'des_ado' => 'Mascota en busca de un hogar amoroso ❤️',
                'fch_pub_ado' => now()->subDays(rand(1, 180)),
                'fch_sol_ado' => now()->subDays(rand(1, 90)),
                'fch_res_ado' => rand(0, 1) ? now()->subDays(rand(1, 30)) : null,
                'est_ado' => $estados[array_rand($estados)],
                'mas_id' => $mas_id,
                'us_act' => $us_act,
                'us_sol' => $us_sol,
                'created_at' => now()->subDays(rand(1, 180)),
                'updated_at' => now(),
            ]);
        }
    }
}