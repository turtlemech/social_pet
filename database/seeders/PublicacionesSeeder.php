<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublicacionesSeeder extends Seeder
{
    public function run(): void
    {
        $contenidos = [
            '¡Hoy mi mascota cumplió años! 🎉',
            'Les presento a mi nuevo amigo 🐕',
            '¿Alguien sabe dónde adoptar un gato?',
            'Mi perro aprendió un nuevo truco 🐶',
            'Día de paseo con mi mascota 🌳',
            'La mejor compañía del mundo ❤️',
            '¿Qué comida recomiendan para perros?',
            'Mi gato es el rey de la casa 👑',
            'Disfrutando el fin de semana juntos',
            'Nueva foto de mi bebé peludo',
            '¿Alguien quiere ser amigo de mi mascota?',
            'Hoy visitamos el veterinario, todo bien ✅',
            'Mi mascota y yo, mejor equipo 🏆',
            'Adopten, no compren 🙏',
            'El amor de un perro es incondicional',
            'Domingo de relax con mi gato',
            '¿Consejos para educar un cachorro?',
            'Mi mascota se volvió viral 🚀',
            'El mejor día de mi vida gracias a él/ella',
            'Comparto esta foto especial'
        ];
        
        for ($i = 1; $i <= 50; $i++) {
            DB::table('publicaciones')->insert([
                'cod_pub' => 'PUB' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'com_pub' => $contenidos[array_rand($contenidos)],
                'img_pub' => 'publicaciones/img_' . $i . '.jpg',
                'us_id' => rand(1, 50),
                'est_pub' => 'activo',
                'created_at' => now()->subHours(rand(1, 720)),
                'updated_at' => now(),
            ]);
        }
    }
}