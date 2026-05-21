<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SoporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $soportes = [
            [
                'cod_us' => 'SOP001',
                'nom_us' => 'Esclavo',
                'app_us' => 'Moderador',
                'apm_us' => 'Sistema',           
                'ema_us' => 'soporte@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '123456789',
                'ubi_us' => 'La Paz',       
                'tip_us' => 'soporte',      
                'est_us' => 'activo',       
                'is_admin' => false,
            ],
            [
                'cod_us' => 'SOP002',
                'nom_us' => 'Ana',
                'app_us' => 'Martínez',
                'apm_us' => 'López',
                'ema_us' => 'ana.soporte@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '611223344',
                'ubi_us' => 'Madrid',
                'tip_us' => 'soporte',
                'est_us' => 'activo',
                'is_admin' => false,
            ],
            [
                'cod_us' => 'SOP003',
                'nom_us' => 'Luis',
                'app_us' => 'Rodríguez',
                'apm_us' => 'Fernández',
                'ema_us' => 'luis.soporte@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '622334455',
                'ubi_us' => 'Barcelona',
                'tip_us' => 'soporte',
                'est_us' => 'activo',
                'is_admin' => false,
            ],
            [
                'cod_us' => 'SOP004',
                'nom_us' => 'Carmen',
                'app_us' => 'González',
                'apm_us' => 'Pérez',
                'ema_us' => 'carmen.soporte@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '633445566',
                'ubi_us' => 'Valencia',
                'tip_us' => 'soporte',
                'est_us' => 'activo',
                'is_admin' => false,
            ],
            [
                'cod_us' => 'SOP005',
                'nom_us' => 'Javier',
                'app_us' => 'Sánchez',
                'apm_us' => 'García',
                'ema_us' => 'javier.soporte@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '644556677',
                'ubi_us' => 'Sevilla',
                'tip_us' => 'soporte',
                'est_us' => 'activo',
                'is_admin' => false,
            ],
            [
                'cod_us' => 'SOP006',
                'nom_us' => 'Laura',
                'app_us' => 'Ramírez',
                'apm_us' => 'Torres',
                'ema_us' => 'laura.soporte@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '655667788',
                'ubi_us' => 'Zaragoza',
                'tip_us' => 'soporte',
                'est_us' => 'activo',
                'is_admin' => false,
            ],
            [
                'cod_us' => 'SOP007',
                'nom_us' => 'Diego',
                'app_us' => 'Flores',
                'apm_us' => 'Rivera',
                'ema_us' => 'diego.soporte@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '666778899',
                'ubi_us' => 'Málaga',
                'tip_us' => 'soporte',
                'est_us' => 'activo',
                'is_admin' => false,
            ],
            [
                'cod_us' => 'SOP008',
                'nom_us' => 'Sofia',
                'app_us' => 'Morales',
                'apm_us' => 'Ortega',
                'ema_us' => 'sofia.soporte@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '677889900',
                'ubi_us' => 'Murcia',
                'tip_us' => 'soporte',
                'est_us' => 'inactivo',
                'is_admin' => false,
            ],
            [
                'cod_us' => 'SOP009',
                'nom_us' => 'Pedro',
                'app_us' => 'Vargas',
                'apm_us' => 'Castillo',
                'ema_us' => 'pedro.soporte@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '688990011',
                'ubi_us' => 'Palma',
                'tip_us' => 'soporte',
                'est_us' => 'activo',
                'is_admin' => false,
            ],
            [
                'cod_us' => 'SOP010',
                'nom_us' => 'Elena',
                'app_us' => 'Ramos',
                'apm_us' => 'Cruz',
                'ema_us' => 'elena.soporte@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '699001122',
                'ubi_us' => 'Bilbao',
                'tip_us' => 'soporte',
                'est_us' => 'activo',
                'is_admin' => false,
            ],
            [
                'cod_us' => 'SOP011',
                'nom_us' => 'Alejandro',
                'app_us' => 'Castro',
                'apm_us' => 'Guerrero',
                'ema_us' => 'alejandro.soporte@socialpet.com',
                'pas_us' => Hash::make('12345678'),
                'tel_us' => '610112233',
                'ubi_us' => 'Alicante',
                'tip_us' => 'soporte',
                'est_us' => 'activo',
                'is_admin' => false,
            ],
        ];

        foreach ($soportes as $soporte) {
            User::create($soporte);
        }
    }
}