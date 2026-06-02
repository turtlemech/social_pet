<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('eventos', function (Blueprint $table) {

            // Imagen/banner
            $table->string('img_eve')->nullable()->after('des_eve');

            // Categoría
            $table->string('cat_eve')->default('General')->after('img_eve');

            // Estado
            $table->enum('est_eve', [
                'activo',
                'cancelado',
                'finalizado'
            ])->default('activo')->after('cat_eve');

            // Evento destacado
            $table->boolean('destacado')->default(false)->after('est_eve');

            // Capacidad máxima
            $table->integer('capacidad_eve')->nullable()->after('destacado');

        });
    }

    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {

            $table->dropColumn([
                'img_eve',
                'cat_eve',
                'est_eve',
                'destacado',
                'capacidad_eve'
            ]);

        });
    }
};