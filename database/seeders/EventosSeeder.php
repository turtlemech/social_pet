<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventosSeeder extends Seeder
{
    public function run(): void
    {
        // Primero crear ubicaciones (sin ciu_ubi ni pai_ubi)
        $ubicaciones = [
            ['nom_ubi' => 'Parque Central'],
            ['nom_ubi' => 'Plaza Principal'],
            ['nom_ubi' => 'Jardín Botánico'],
            ['nom_ubi' => 'Parque de la Amistad'],
            ['nom_ubi' => 'Plaza Murillo'],
            ['nom_ubi' => 'Parque Kennedy'],
            ['nom_ubi' => 'Parque de las Leyendas'],
            ['nom_ubi' => 'Centro de Convenciones'],
            ['nom_ubi' => 'Parque Simón Bolívar'],
            ['nom_ubi' => 'Plaza de Armas'],
        ];
        
        foreach ($ubicaciones as $ubicacion) {
            DB::table('ubicacion')->insert([
                'nom_ubi' => $ubicacion['nom_ubi'],
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
        
        // Obtener los IDs de los usuarios existentes
        $usuarios = DB::table('usuarios')->pluck('id')->toArray();
        
        // Si no hay usuarios, crear al menos uno de respaldo
        if (empty($usuarios)) {
            DB::table('usuarios')->insert([
                'name' => 'Usuario Default',
                'email' => 'default@example.com',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $usuarios = DB::table('usuarios')->pluck('id')->toArray();
        }
        
        for ($i = 1; $i <= 50; $i++) {
            $evento = $eventos_data[array_rand($eventos_data)];
            DB::table('eventos')->insert([
                'nom_eve' => $evento['nom_eve'] . ' ' . $i,
                'des_eve' => $evento['des_eve'],
                'fch_eve' => now()->addDays(rand(1, 365)),
                'usuario_id' => $usuarios[array_rand($usuarios)], // Agregar usuario_id requerido
                'id_ubicacion' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}