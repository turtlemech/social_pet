<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = ['alimento', 'juguete', 'accesorio', 'ropa', 'salud', 'otro'];
        
        $productos_nombres = [
            'alimento' => ['Croquetas Premium', 'Comida Húmeda', 'Snacks Naturales', 'Suplemento Vitamínico'],
            'juguete' => ['Pelota Anti-estrés', 'Cuerda Dental', 'Juguete Squeaker', 'Láser para Gatos'],
            'accesorio' => ['Cama Ortopédica', 'Collar Antipulgas', 'Correa Extensible', 'Transportadora'],
            'ropa' => ['Chaleco Térmico', 'Impermeable', 'Suéter Navideño', 'Corbata Formal'],
            'salud' => ['Shampoo Especial', 'Cepillo Dental', 'Vitaminas', 'Repelente Natural'],
            'otro' => ['Comedero Inteligente', 'Bebedero Automático', 'Cepillo Deslanador', 'Rascador']
        ];
        
        for ($i = 1; $i <= 50; $i++) {
            $categoria = $categorias[array_rand($categorias)];
            $nombre = $productos_nombres[$categoria][array_rand($productos_nombres[$categoria])];
            
            DB::table('productos')->insert([
                'cod_pro' => 'PRO' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'nom_pro' => $nombre . ' ' . $i,
                'des_pro' => 'Producto de alta calidad para tu mascota',
                'pre_pro' => rand(50, 500) + (rand(0, 99) / 100),
                'cat_pro' => $categoria,
                'est_pro' => 'activo',
                'img_pro' => 'productos/prod_' . $i . '.jpg',
                'us_ven' => rand(1, 50),
                'created_at' => now()->subDays(rand(1, 180)),
                'updated_at' => now(),
            ]);
        }
    }
}