<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParticipacionEventoSeeder extends Seeder
{
    public function run(): void
    {
        $estados = ['aceptada', 'rechazada', 'en espera'];
        $participaciones = [];
        $unicas = [];
        
        for ($i = 1; $i <= 50; $i++) {
            // Evitar duplicados
            do {
                $evento_id = rand(1, 50);
                $usuario_id = rand(1, 60);
                $clave = $evento_id . '-' . $usuario_id;
            } while (in_array($clave, $unicas));
            
            $unicas[] = $clave;
            
            $participaciones[] = [
                'est_par' => $estados[array_rand($estados)],
                'evento_id' => $evento_id,
                'usuario_id' => $usuario_id,
                'created_at' => now()->subDays(rand(1, 180)),
                'updated_at' => now(),
            ];
        }
        
        foreach ($participaciones as $participacion) {
            DB::table('participacion_evento')->insert($participacion);
        }
    }
}