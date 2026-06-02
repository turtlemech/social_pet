<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MensajesSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['texto', 'imagen', 'video'];
        $mensajes_texto = [
            '¡Hola! ¿Cómo estás?',
            '¿Viste la nueva foto de mi mascota?',
            'Me encantó tu publicación',
            '¿Quieres ser mi amigo?',
            'Te invito a un evento de mascotas',
            'Gracias por aceptar mi solicitud',
            '¡Qué bonito tu perro!',
            '¿Dónde compraste ese accesorio?',
            'Te recomiendo este veterinario',
            'Vamos al parque este fin de semana',
            'Adopté un nuevo gatito 🐱',
            'Mi perro aprendió un truco nuevo',
            '¿Qué comida le das a tu mascota?',
            'Felicidades por tu nueva mascota',
            'Es muy lindo/a tu bebé peludo'
        ];
        
        for ($i = 1; $i <= 50; $i++) {
            $tipo = $tipos[array_rand($tipos)];
            DB::table('mensajes')->insert([
                'cod_mens' => 'MEN' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'con_men' => $tipo == 'texto' ? $mensajes_texto[array_rand($mensajes_texto)] : null,
                'url_men' => $tipo != 'texto' ? 'mensajes/archivo_' . $i . '.' . ($tipo == 'imagen' ? 'jpg' : 'mp4') : null,
                'tip_men' => $tipo,
                'lei_mens' => rand(0, 1),
                'fch_lei_mens' => rand(0, 1) ? now()->subHours(rand(1, 48)) : null,
                'con_id' => rand(1, 50),
                'us_rem' => rand(1, 60),
                'created_at' => now()->subHours(rand(1, 720)),
                'updated_at' => now(),
            ]);
        }
    }
}