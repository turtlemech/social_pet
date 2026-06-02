<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventosSeeder extends Seeder
{
    public function run(): void
    {
        // ================= UBICACIONES =================

        $ubicaciones = [

            [
                'nom_ubi' => 'Parque Central',
                'latitud' => 19.432608,
                'longitud' => -99.133209,
            ],

            [
                'nom_ubi' => 'Plaza Principal',
                'latitud' => 20.659699,
                'longitud' => -103.349609,
            ],

            [
                'nom_ubi' => 'Jardín Botánico',
                'latitud' => 25.686613,
                'longitud' => -100.316116,
            ],

            [
                'nom_ubi' => 'Parque de la Amistad',
                'latitud' => -16.500000,
                'longitud' => -68.150002,
            ],

            [
                'nom_ubi' => 'Plaza Murillo',
                'latitud' => -16.495545,
                'longitud' => -68.133622,
            ],

            [
                'nom_ubi' => 'Parque Kennedy',
                'latitud' => -12.121111,
                'longitud' => -77.029722,
            ],

            [
                'nom_ubi' => 'Parque de las Leyendas',
                'latitud' => -12.070000,
                'longitud' => -77.090000,
            ],

            [
                'nom_ubi' => 'Centro de Convenciones',
                'latitud' => 4.711000,
                'longitud' => -74.072090,
            ],

            [
                'nom_ubi' => 'Parque Simón Bolívar',
                'latitud' => 4.658333,
                'longitud' => -74.093611,
            ],

            [
                'nom_ubi' => 'Plaza de Armas',
                'latitud' => -13.516667,
                'longitud' => -71.978889,
            ],

        ];

        foreach ($ubicaciones as $ubicacion) {

            DB::table('ubicacion')->insert([

                'nom_ubi' => $ubicacion['nom_ubi'],

                'latitud' => $ubicacion['latitud'],

                'longitud' => $ubicacion['longitud'],

                'created_at' => now(),

                'updated_at' => now(),

            ]);
        }

        // ================= EVENTOS =================

        $eventos_data = [

            [
                'nom_eve' => 'Feria de Mascotas',
                'des_eve' => 'Ven a conocer productos y servicios para tu mascota'
            ],

            [
                'nom_eve' => 'Adopción Responsable',
                'des_eve' => 'Jornada de adopción de perros y gatos'
            ],

            [
                'nom_eve' => 'Competencia Canina',
                'des_eve' => 'Torneo de agilidad y obediencia'
            ],

            [
                'nom_eve' => 'Exposición Felina',
                'des_eve' => 'Muestra de razas de gatos'
            ],

            [
                'nom_eve' => 'Taller de Primeros Auxilios',
                'des_eve' => 'Aprende a cuidar a tu mascota'
            ],

            [
                'nom_eve' => 'Caminata con Mascotas',
                'des_eve' => 'Recorrido por el parque con tu peludo'
            ],

            [
                'nom_eve' => 'Fiesta de Cumpleaños Canino',
                'des_eve' => 'Celebración colectiva para perros'
            ],

            [
                'nom_eve' => 'Conferencia de Nutrición',
                'des_eve' => 'Alimentación saludable para mascotas'
            ],

            [
                'nom_eve' => 'Desfile de Mascotas',
                'des_eve' => 'Pasarela con tus mascotas'
            ],

            [
                'nom_eve' => 'Maratón de Adopciones',
                'des_eve' => 'Encuentra un nuevo amigo'
            ],

        ];

        // Obtener usuarios existentes

        $usuarios = DB::table('usuarios')->pluck('id')->toArray();

        // Crear usuario por defecto si no existe ninguno

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

                'usuario_id' => $usuarios[array_rand($usuarios)],

                'id_ubicacion' => rand(1, 10),

                'created_at' => now(),

                'updated_at' => now(),

            ]);
        }
    }
}