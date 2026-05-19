<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventosSeeder extends Seeder
{
    public function run(): void
    {
        // Primero crear ubicaciones
        $ubicaciones = [
            ['nom_ubi' => 'Parque Central', 'ciu_ubi' => 'Ciudad de México', 'pai_ubi' => 'México'],
            ['nom_ubi' => 'Plaza Principal', 'ciu_ubi' => 'Guadalajara', 'pai_ubi' => 'México'],
            ['nom_ubi' => 'Jardín Botánico', 'ciu_ubi' => 'Monterrey', 'pai_ubi' => 'México'],
            ['nom_ubi' => 'Parque de la Amistad', 'ciu_ubi' => 'La Paz', 'pai_ubi' => 'Bolivia'],
            ['nom_ubi' => 'Plaza Murillo', 'ciu_ubi' => 'La Paz', 'pai_ubi' => 'Bolivia'],
            ['nom_ubi' => 'Parque Kennedy', 'ciu_ubi' => 'Lima', 'pai_ubi' => 'Perú'],
            ['nom_ubi' => 'Parque de las Leyendas', 'ciu_ubi' => 'Lima', 'pai_ubi' => 'Perú'],
            ['nom_ubi' => 'Centro de Convenciones', 'ciu_ubi' => 'Bogotá', 'pai_ubi' => 'Colombia'],
            ['nom_ubi' => 'Parque Simón Bolívar', 'ciu_ubi' => 'Bogotá', 'pai_ubi' => 'Colombia'],
            ['nom_ubi' => 'Plaza de Armas', 'ciu_ubi' => 'Cusco', 'pai_ubi' => 'Perú'],
        ];
        
        foreach ($ubicaciones as $ubicacion) {
            DB::table('ubicacion')->insert([
                'nom_ubi' => $ubicacion['nom_ubi'],
                'ciu_ubi' => $ubicacion['ciu_ubi'],
                'pai_ubi' => $ubicacion['pai_ubi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Eventos
        $eventos_data = [
            ['nom_eve' => 'Feria de Mascotas 2024', 'des_eve' => 'Ven a conocer productos y servicios para tu mascota'],
            ['nom_eve' => 'Adopción Responsable', 'des_eve' => 'Jornada de adopción de perros y gatos'],
            ['nom_eve' => 'Competencia Canina', 'des_eve' => 'Torneo de agilidad y obediencia'],
            ['nom_eve' => 'Exposición Felina', 'des_eve' => 'Muestra de razas de gatos'],
            ['nom_eve' => 'Taller de Primeros Auxilios', 'des_eve' => 'Aprende a cuidar a tu mascota'],
            ['nom_eve' => 'Caminata con Mascotas', 'des_eve' => 'Recorrido por el parque con tu peludo'],
            ['nom_eve' => 'Fiesta de Cumpleaños Canino', 'des_eve' => 'Celebración colectiva para perros'],
            ['nom_eve' => 'Conferencia de Nutrición', 'des_eve' => 'Alimentación saludable para mascotas'],
            ['nom_eve' => 'Desfile de Mascotas', 'des_eve' => 'Pasarela con tus mascotas'],
            ['nom_eve' => 'Maratón de Adopciones', 'des_eve' => 'Encuentra un nuevo amigo'],
        ];
        
        for ($i = 1; $i <= 50; $i++) {
            $evento = $eventos_data[array_rand($eventos_data)];
            DB::table('eventos')->insert([
                'nom_eve' => $evento['nom_eve'] . ' ' . $i,
                'des_eve' => $evento['des_eve'],
                'fch_eve' => now()->addDays(rand(1, 365)),
                'id_ubicacion' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
