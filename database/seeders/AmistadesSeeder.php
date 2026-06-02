<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmistadesSeeder extends Seeder
{
    public function run(): void
    {
        $estados = ['pendiente', 'aceptada', 'rechazada'];
        $amistades = [];
        $pares = [];
        
        for ($i = 1; $i <= 50; $i++) {
            // Evitar duplicados y auto-amistad
            do {
                $us_sol = rand(1, 50);
                $us_rec = rand(1, 50);
                $par = min($us_sol, $us_rec) . '-' . max($us_sol, $us_rec);
            } while ($us_sol == $us_rec || in_array($par, $pares));
            
            $pares[] = $par;
            
            $amistades[] = [
                'cod_ami' => 'AMI' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'est_ami' => $estados[array_rand($estados)],
                'us_sol' => $us_sol,
                'us_rec' => $us_rec,
                'created_at' => now()->subDays(rand(1, 180)),
                'updated_at' => now(),
            ];
        }
        
        foreach ($amistades as $amistad) {
            DB::table('amistades')->insert($amistad);
        }
    }
}