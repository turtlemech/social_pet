<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->enum('tipo_notificacion', ['amistad', 'like', 'comentario', 'evento', 'mensaje', 'adopcion', 'producto']);
            $table->string('mensaje', 255);
            $table->string('enlace', 255)->nullable();
            $table->boolean('leida')->default(false);
            $table->timestamps();
            
            $table->index(['id_usuario', 'leida', 'created_at']);
            $table->index('tipo_notificacion');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};