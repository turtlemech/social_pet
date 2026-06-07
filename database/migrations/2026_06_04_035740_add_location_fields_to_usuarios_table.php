<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {

            $table->decimal('latitud', 10, 8)
                ->nullable()
                ->after('ubi_us');

            $table->decimal('longitud', 11, 8)
                ->nullable()
                ->after('latitud');

            $table->boolean('ubicacion_activa')
                ->default(false)
                ->after('longitud');

            $table->timestamp('ubicacion_actualizada')
                ->nullable()
                ->after('ubicacion_activa');

        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {

            $table->dropColumn([
                'latitud',
                'longitud',
                'ubicacion_activa',
                'ubicacion_actualizada'
            ]);

        });
    }
};