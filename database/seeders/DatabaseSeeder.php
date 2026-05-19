<?php

namespace Database\Seeders;

use App\Models\Soporte;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            Userseeder::class,
            Soporteseeder::class,
            EspeciesSeeder::class,
            MascotasSeeder::class,
            AmistadesSeeder::class,
            PublicacionesSeeder::class,
            ComentariosSeeder::class,
            ReaccionesSeeder::class,
            EventosSeeder::class,         
            ParticipacionEventoSeeder::class,
            ProductosSeeder::class,
            AdopcionesSeeder::class,
            ConversacionesSeeder::class,
            ParticipantesSeeder::class,
            MensajesSeeder::class,
            TicketsSoporteSeeder::class,
        ]);
    }
}