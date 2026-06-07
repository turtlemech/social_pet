<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('publicaciones', function (Blueprint $table) {

            // Música
            $table->string('musica')->nullable();

            $table->string('musica_artista')->nullable();

            $table->string('musica_preview')->nullable();

            // Ubicación
            $table->string('ubicacion')->nullable();

            $table->decimal('latitud', 10, 8)->nullable();

            $table->decimal('longitud', 11, 8)->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('publicaciones', function (Blueprint $table) {

            $table->dropColumn([
                'musica',
                'musica_artista',
                'musica_preview',
                'ubicacion',
                'latitud',
                'longitud'
            ]);

        });
    }
};