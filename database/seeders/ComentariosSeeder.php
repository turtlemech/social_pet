<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComentariosSeeder extends Seeder
{
    public function run(): void
    {
        $comentarios_texto = [
            '¡Qué lindo! 😍',
            'Muy bonita foto',
            'Me encanta',
            'Que tierno/a',
            'Felicitaciones 🎉',
            'Hermosa mascota',
            'Gracias por compartir',
            'Excelente publicación',
            'Me alegra mucho',
            'Que buena noticia',
            'Totalmente de acuerdo',
            'Me identifico con esto',
            'Wow, increíble',
            'Qué suerte tienes',
            'Ojalá tuviera uno igual',
            'Genial!',
            'Super publicación',
            'Me encanta ver esto',
            'Qué bonito mensaje',
            'Inspirador'
        ];
        
        for ($i = 1; $i <= 50; $i++) {
            DB::table('comentarios')->insert([
                'con_com' => $comentarios_texto[array_rand($comentarios_texto)],
                'id_publicacion' => rand(1, 50),
                'id_usuario' => rand(1, 60), // Incluye usuarios normales y soporte
                'estado' => 'activo',
                'created_at' => now()->subHours(rand(1, 720)),
                'updated_at' => now(),
            ]);
        }
    }
}