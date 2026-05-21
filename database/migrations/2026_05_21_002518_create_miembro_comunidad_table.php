<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('miembro_comunidad', function (Blueprint $table) {

            // Primary Key
            $table->id('cod_mie_com');

            // Relación comunidad
            $table->unsignedBigInteger('cod_com');

            // Relación usuario
            $table->unsignedBigInteger('id');

            // Rol del miembro
            $table->enum('rol_mie_com', [
                'admin',
                'moderador',
                'miembro'
            ])->default('miembro');

            // Fecha de unión
            $table->timestamp('fch_union_com')
                  ->useCurrent();


            // Comunidad
            $table->foreign('cod_com')
                  ->references('cod_com')
                  ->on('comunidad')
                  ->onDelete('cascade');

            // Usuario
            $table->foreign('id')
                  ->references('id')
                  ->on('usuarios')
                  ->onDelete('cascade');

            // Evita que un usuario se una dos veces
            // a la misma comunidad
            $table->unique(['cod_com', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miembro_comunidad');
    }
};