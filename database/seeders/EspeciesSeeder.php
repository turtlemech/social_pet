<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class EspeciesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('especies')->insert([
            [
                'id' => 1, 
                'nom_esp' => 'Perro', 
                'raz_mas' => 'Mamífero doméstico', 
                'tam_mas' => 'Mediano',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2, 
                'nom_esp' => 'Gato', 
                'raz_mas' => 'Mamífero felino', 
                'tam_mas' => 'Pequeño',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 3, 
                'nom_esp' => 'Ave', 
                'raz_mas' => 'Ave doméstica', 
                'tam_mas' => 'Pequeño',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 4, 
                'nom_esp' => 'Roedor', 
                'raz_mas' => 'Roedor doméstico', 
                'tam_mas' => 'Pequeño',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 5, 
                'nom_esp' => 'Reptil', 
                'raz_mas' => 'Reptil doméstico', 
                'tam_mas' => 'Pequeño',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 6, 
                'nom_esp' => 'Pez', 
                'raz_mas' => 'Pez de acuario', 
                'tam_mas' => 'Pequeño',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 7, 
                'nom_esp' => 'Conejo', 
                'raz_mas' => 'Mamífero lagomorfo', 
                'tam_mas' => 'Pequeño',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 8, 
                'nom_esp' => 'Otro', 
                'raz_mas' => 'Otra especie', 
                'tam_mas' => 'Variable',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
