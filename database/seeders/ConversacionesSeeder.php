<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConversacionesSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['individual', 'grupal'];
        
        for ($i = 1; $i <= 50; $i++) {
            $tipo = $tipos[array_rand($tipos)];
            DB::table('conversaciones')->insert([
                'cod_con' => 'CON' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'tip_con' => $tipo,
                'nom_con' => $tipo == 'grupal' ? 'Grupo de Mascotas ' . $i : null,
                'us_crea' => rand(1, 60),
                'fch_act_con' => now()->subHours(rand(1, 720)),
                'act_con' => true,
                'created_at' => now()->subDays(rand(1, 180)),
                'updated_at' => now(),
            ]);
        }
    }
}