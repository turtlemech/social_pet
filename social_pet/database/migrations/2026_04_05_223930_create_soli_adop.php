<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes_adopcion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mascota_adopcion')->constrained('mascotas_adopcion')->onDelete('cascade');
            $table->foreignId('id_usuario_solicitante')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_usuario_protectora')->constrained('users')->onDelete('cascade');
            $table->enum('estado_solicitud', ['pendiente', 'en_revision', 'aprobada', 'rechazada', 'finalizada'])->default('pendiente');
            $table->text('mensaje')->nullable();
            $table->timestamp('fecha_respuesta')->nullable();
            $table->text('comentarios_revision')->nullable();
            $table->timestamps();
            
            $table->index('estado_solicitud', 'solicitudes_estado_idx');
            $table->index(['id_usuario_solicitante', 'estado_solicitud'], 'solicitudes_user_estado_idx');
            $table->index(['id_mascota_adopcion', 'estado_solicitud'], 'solicitudes_mascota_estado_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_adopcion');
    }
};