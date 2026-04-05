<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistentes_eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_evento')->constrained('eventos')->onDelete('cascade');
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_mascota')->nullable()->constrained('mascotas')->onDelete('set null');
            $table->enum('estado_asistencia', ['confirmado', 'pendiente', 'cancelado'])->default('pendiente');
            $table->timestamps();
            
            $table->unique(['id_evento', 'id_usuario'], 'asistentes_unique');
            $table->index('estado_asistencia', 'asistentes_estado_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistentes_eventos');
    }
};