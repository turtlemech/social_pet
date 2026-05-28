<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReaccionesSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['like', 'love', 'wow', 'triste', 'enojado'];
        $reacciones = [];
        $unicas = [];
        
        for ($i = 1; $i <= 50; $i++) {
            // Evitar duplicados de usuario-publicación
            do {
                $id_publicacion = rand(1, 50);
                $id_usuario = rand(1, 60);
                $clave = $id_publicacion . '-' . $id_usuario;
            } while (in_array($clave, $unicas));
            
            $unicas[] = $clave;
            
            $reacciones[] = [
                'cod_rea' => 'REA' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'tip_rea' => $tipos[array_rand($tipos)],
                'id_publicacion' => $id_publicacion,
                'id_usuario' => $id_usuario,
                'created_at' => now()->subDays(rand(1, 180)),
                'updated_at' => now(),
            ];
        }
        
        foreach ($reacciones as $reaccion) {
            DB::table('reacciones')->insert($reaccion);
        }
    }
}
