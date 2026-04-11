<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reacciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_publicacion')
                ->constrained('publicaciones')
                ->onDelete('cascade');
            $table->foreignId('id_usuario')
                ->constrained('usuarios')  // Cambiado de 'users' a 'usuarios'
                ->onDelete('cascade');
            $table->enum('tipo', ['like', 'amor', 'cuidado', 'divertido'])->default('like');
            $table->timestamps();
            
            $table->unique(['id_publicacion', 'id_usuario'], 'reacciones_unique');
            $table->index('tipo', 'reacciones_tipo_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reacciones');
    }
};