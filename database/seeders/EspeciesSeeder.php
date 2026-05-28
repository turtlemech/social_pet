<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspeciesSeeder extends Seeder
{
    public function run(): void
    {
        $especies = [];
        
        // Principales especies
        $principales = [
            ['nom_esp' => 'Perro', 'raz_mas' => 'Canino', 'tam_mas' => 'Variable'],
            ['nom_esp' => 'Gato', 'raz_mas' => 'Felino', 'tam_mas' => 'Pequeño-Mediano'],
            ['nom_esp' => 'Ave', 'raz_mas' => 'Ave', 'tam_mas' => 'Pequeño'],
            ['nom_esp' => 'Reptil', 'raz_mas' => 'Reptil', 'tam_mas' => 'Variable'],
            ['nom_esp' => 'Roedor', 'raz_mas' => 'Roedor', 'tam_mas' => 'Pequeño'],
            ['nom_esp' => 'Pez', 'raz_mas' => 'Pez', 'tam_mas' => 'Pequeño-Mediano'],
            ['nom_esp' => 'Conejo', 'raz_mas' => 'Lagomorfo', 'tam_mas' => 'Pequeño'],
            ['nom_esp' => 'Hamster', 'raz_mas' => 'Roedor', 'tam_mas' => 'Muy Pequeño'],
            ['nom_esp' => 'Cobaya', 'raz_mas' => 'Roedor', 'tam_mas' => 'Pequeño'],
            ['nom_esp' => 'Hurón', 'raz_mas' => 'Mustélido', 'tam_mas' => 'Pequeño'],
        ];
        
        // Razas específicas de perros
        $razas_perro = [
            ['nom_esp' => 'Labrador', 'raz_mas' => 'Canino', 'tam_mas' => 'Grande'],
            ['nom_esp' => 'Pastor Alemán', 'raz_mas' => 'Canino', 'tam_mas' => 'Grande'],
            ['nom_esp' => 'Bulldog', 'raz_mas' => 'Canino', 'tam_mas' => 'Mediano'],
            ['nom_esp' => 'Poodle', 'raz_mas' => 'Canino', 'tam_mas' => 'Pequeño-Mediano'],
            ['nom_esp' => 'Chihuahua', 'raz_mas' => 'Canino', 'tam_mas' => 'Muy Pequeño'],
            ['nom_esp' => 'Golden Retriever', 'raz_mas' => 'Canino', 'tam_mas' => 'Grande'],
            ['nom_esp' => 'Beagle', 'raz_mas' => 'Canino', 'tam_mas' => 'Mediano'],
            ['nom_esp' => 'Boxer', 'raz_mas' => 'Canino', 'tam_mas' => 'Grande'],
            ['nom_esp' => 'Dálmata', 'raz_mas' => 'Canino', 'tam_mas' => 'Grande'],
            ['nom_esp' => 'Schnauzer', 'raz_mas' => 'Canino', 'tam_mas' => 'Mediano'],
            ['nom_esp' => 'Yorkshire', 'raz_mas' => 'Canino', 'tam_mas' => 'Muy Pequeño'],
            ['nom_esp' => 'Rottweiler', 'raz_mas' => 'Canino', 'tam_mas' => 'Grande'],
            ['nom_esp' => 'Doberman', 'raz_mas' => 'Canino', 'tam_mas' => 'Grande'],
            ['nom_esp' => 'Husky', 'raz_mas' => 'Canino', 'tam_mas' => 'Grande'],
            ['nom_esp' => 'Shih Tzu', 'raz_mas' => 'Canino', 'tam_mas' => 'Pequeño'],
        ];
        
        // Razas específicas de gatos
        $razas_gato = [
            ['nom_esp' => 'Persa', 'raz_mas' => 'Felino', 'tam_mas' => 'Mediano'],
            ['nom_esp' => 'Siamés', 'raz_mas' => 'Felino', 'tam_mas' => 'Mediano'],
            ['nom_esp' => 'Maine Coon', 'raz_mas' => 'Felino', 'tam_mas' => 'Grande'],
            ['nom_esp' => 'Bengalí', 'raz_mas' => 'Felino', 'tam_mas' => 'Mediano'],
            ['nom_esp' => 'Esfinge', 'raz_mas' => 'Felino', 'tam_mas' => 'Mediano'],
            ['nom_esp' => 'Ragdoll', 'raz_mas' => 'Felino', 'tam_mas' => 'Grande'],
            ['nom_esp' => 'Angora', 'raz_mas' => 'Felino', 'tam_mas' => 'Mediano'],
            ['nom_esp' => 'Azul Ruso', 'raz_mas' => 'Felino', 'tam_mas' => 'Mediano'],
            ['nom_esp' => 'Sphynx', 'raz_mas' => 'Felino', 'tam_mas' => 'Mediano'],
            ['nom_esp' => 'Birmano', 'raz_mas' => 'Felino', 'tam_mas' => 'Mediano'],
        ];
        
        // Otras especies diversas
        $otras = [
            ['nom_esp' => 'Tortuga', 'raz_mas' => 'Reptil', 'tam_mas' => 'Pequeño-Mediano'],
            ['nom_esp' => 'Iguana', 'raz_mas' => 'Reptil', 'tam_mas' => 'Mediano'],
            ['nom_esp' => 'Serpiente', 'raz_mas' => 'Reptil', 'tam_mas' => 'Variable'],
            ['nom_esp' => 'Gecko', 'raz_mas' => 'Reptil', 'tam_mas' => 'Pequeño'],
            ['nom_esp' => 'Loro', 'raz_mas' => 'Ave', 'tam_mas' => 'Pequeño-Mediano'],
            ['nom_esp' => 'Canario', 'raz_mas' => 'Ave', 'tam_mas' => 'Muy Pequeño'],
            ['nom_esp' => 'Periquito', 'raz_mas' => 'Ave', 'tam_mas' => 'Muy Pequeño'],
            ['nom_esp' => 'Cacatúa', 'raz_mas' => 'Ave', 'tam_mas' => 'Mediano'],
            ['nom_esp' => 'Guppy', 'raz_mas' => 'Pez', 'tam_mas' => 'Muy Pequeño'],
            ['nom_esp' => 'Betta', 'raz_mas' => 'Pez', 'tam_mas' => 'Pequeño'],
            ['nom_esp' => 'Goldfish', 'raz_mas' => 'Pez', 'tam_mas' => 'Pequeño-Mediano'],
            ['nom_esp' => 'Chinchilla', 'raz_mas' => 'Roedor', 'tam_mas' => 'Pequeño'],
            ['nom_esp' => 'Erizo', 'raz_mas' => 'Erinaceinae', 'tam_mas' => 'Muy Pequeño'],
            ['nom_esp' => 'Cerdo Vietnámico', 'raz_mas' => 'Suido', 'tam_mas' => 'Mediano'],
        ];
        
        $todas = array_merge($principales, $razas_perro, $razas_gato, $otras);
        
        foreach ($todas as $especie) {
            DB::table('especies')->insert([
                'nom_esp' => $especie['nom_esp'],
                'raz_mas' => $especie['raz_mas'],
                'tam_mas' => $especie['tam_mas'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}