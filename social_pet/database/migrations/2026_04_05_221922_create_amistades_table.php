<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('amistades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario_solicitante')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_usuario_destinatario')->constrained('users')->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'aceptada', 'rechazada', 'bloqueada'])->default('pendiente');
            $table->timestamp('fecha_respuesta')->nullable();
            $table->timestamps();
            
            $table->unique(['id_usuario_solicitante', 'id_usuario_destinatario'], 'amistades_unique');
            $table->index('estado', 'amistades_estado_idx');
            $table->index(['id_usuario_destinatario', 'estado'], 'amistades_dest_estado_idx');
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('amistades');
    }
};