<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_mascota')->nullable()->constrained('mascotas')->onDelete('set null');
            $table->text('contenido');
            $table->enum('tipo', ['texto', 'foto', 'video', 'evento'])->default('texto');
            $table->string('multimedia_url', 255)->nullable();
            $table->string('ubicacion', 255)->nullable();
            $table->enum('estado', ['activo', 'eliminado', 'reportado'])->default('activo');
            $table->timestamps();
            
            $table->index(['id_usuario', 'created_at'], 'publicaciones_user_date_idx');
            $table->index('tipo', 'publicaciones_tipo_idx');
            $table->index('estado', 'publicaciones_estado_idx');
            $table->index('created_at', 'publicaciones_date_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};