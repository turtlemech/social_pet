<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MascotasSeeder extends Seeder
{
    public function run(): void
    {
        $mascotas = [];
        
        $nombres = ['Luna', 'Max', 'Bella', 'Rocky', 'Coco', 'Nala', 'Simba', 'Toby', 'Chloe', 'Zeus', 
                    'Mia', 'Bruno', 'Lola', 'Thor', 'Lucas', 'Emma', 'Duke', 'Lily', 'Charlie', 'Daisy'];
        
        $descripciones = [
            'Muy juguetón y cariñoso', 'Le encanta salir a pasear', 'Es un poco tímido al principio',
            'Muy inteligente y obediente', 'Le fascina dormir', 'Muy activo y energético',
            'Es muy glotón', 'Le encanta que le acaricien', 'Muy protector con la familia',
            'Adora jugar con pelotas', 'Es muy sociable con otros animales', 'Tiene mucha energía'
        ];
        
        for ($i = 1; $i <= 50; $i++) {
            $especie_id = rand(1, 50);
            $usuario_id = rand(1, 50); // Usuarios del 1-50
            $sexo = rand(0, 1) ? 'macho' : 'hembra';
            
            $mascotas[] = [
                'nom_mas' => $nombres[array_rand($nombres)],
                'sex_mas' => $sexo,
                'des_mas' => $descripciones[array_rand($descripciones)],
                'fot_mas' => 'mascotas/foto_' . $i . '.jpg',
                'est_mas' => 'activo',
                'especie_id' => $especie_id,
                'usuario_id' => $usuario_id,
                'created_at' => now()->subDays(rand(1, 365)),
                'updated_at' => now(),
            ];
        }
        
        foreach ($mascotas as $mascota) {
            DB::table('mascotas')->insert($mascota);
        }
    }
}