<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_publicacion')
                ->constrained('publicaciones')
                ->onDelete('cascade');
            $table->foreignId('id_usuario')
                ->constrained('usuarios')  // Cambiado de 'users' a 'usuarios'
                ->onDelete('cascade');
            $table->text('comentario');
            $table->enum('estado', ['activo', 'eliminado'])->default('activo');
            $table->timestamps();
            
            $table->index(['id_publicacion', 'created_at'], 'comentarios_pub_date_idx');
            $table->index('id_usuario', 'comentarios_user_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};