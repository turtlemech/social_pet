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
        Schema::create('comunidad', function (Blueprint $table) {

            // PK
            $table->id('cod_com');

            // Datos comunidad
            $table->string('nom_com', 100);

            $table->text('des_com')->nullable();

            $table->string('fot_com')->nullable();

            // Privacidad
            $table->enum('pri_com', [
                'publica',
                'privada'
            ])->default('publica');

            // Estado
            $table->enum('est_com', [
                'activa',
                'inactiva'
            ])->default('activa');

            // Fecha creación
            $table->timestamp('fch_cre_com')
                  ->useCurrent();

            // Usuario creador
            $table->unsignedBigInteger('id');

            // Foreign Key
            $table->foreign('id')
                  ->references('id')
                  ->on('usuarios')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comunidad');
    }
};