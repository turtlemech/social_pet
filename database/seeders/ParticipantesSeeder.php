<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParticipantesSeeder extends Seeder
{
    public function run(): void
    {
        $participantes = [];
        $unicas = [];
        
        for ($i = 1; $i <= 50; $i++) {
            // Evitar duplicados en la misma conversación
            do {
                $con_id = rand(1, 50);
                $us_id = rand(1, 60);
                $clave = $con_id . '-' . $us_id;
            } while (in_array($clave, $unicas));
            
            $unicas[] = $clave;
            
            $participantes[] = [
                'cod_par' => 'PAR' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'con_id' => $con_id,
                'us_id' => $us_id,
                'fch_uni_par' => now()->subDays(rand(1, 180)),
                'fch_sal_par' => rand(0, 1) ? now()->subDays(rand(1, 30)) : null,
                'created_at' => now()->subDays(rand(1, 180)),
                'updated_at' => now(),
            ];
        }
        
        foreach ($participantes as $participante) {
            DB::table('participantes')->insert($participante);
        }
    }
}