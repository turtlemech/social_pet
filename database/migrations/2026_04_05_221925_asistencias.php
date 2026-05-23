<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->string('cod_asi', 8)->unique();
            $table->enum('est_asi', ['confirmada', 'cancelada'])->default('confirmada');

            // CAMBIADO
            $table->unsignedBigInteger('que_id')->nullable();

            $table->foreignId('us_id')->constrained('usuarios')->onDelete('cascade');

            $table->timestamps();

            $table->index(['que_id', 'est_asi'], 'asistencias_quedada_estado_idx');
            $table->index(['us_id', 'est_asi'], 'asistencias_usuario_estado_idx');
            $table->unique(['que_id', 'us_id'], 'asistencias_unique_asistencia');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};