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
        Schema::create('solicitudes_adopcion', function (Blueprint $table) {

            $table->id();

            // Relaciones
            $table->unsignedBigInteger('adopcion_id');
            $table->unsignedBigInteger('usuario_id');

            // Datos de contacto
            $table->string('telefono', 20);
            $table->string('ciudad', 100);
            $table->text('direccion');

            // Vivienda
            $table->enum('tipo_vivienda', [
                'casa',
                'departamento',
                'cuarto'
            ]);

            $table->enum('tenencia_vivienda', [
                'propia',
                'alquilada',
                'familiar'
            ]);

            $table->boolean('tiene_patio')->default(false);

            // Familia
            $table->integer('personas_hogar')->default(1);
            $table->boolean('hay_ninos')->default(false);

            // Mascotas
            $table->boolean('tiene_mascotas')->default(false);
            $table->text('detalle_mascotas')->nullable();

            // Motivo de adopción
            $table->text('motivo_adopcion');

            // Estado
            $table->enum('estado', [
                'pendiente',
                'aprobada',
                'rechazada'
            ])->default('pendiente');

            $table->timestamps();

            // Foreign Keys
            $table->foreign('adopcion_id')
                ->references('id')
                ->on('adopciones')
                ->onDelete('cascade');

            $table->foreign('usuario_id')
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
        Schema::dropIfExists('solicitudes_adopcion');
    }
};