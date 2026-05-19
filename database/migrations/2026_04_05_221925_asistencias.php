<?php
// database/migrations/2024_01_01_000005_create_asistencias_table.php

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
            $table->foreignId('que_id')->constrained('quedadas')->onDelete('cascade');
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