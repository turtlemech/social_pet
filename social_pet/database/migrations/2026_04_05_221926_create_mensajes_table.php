<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_conversacion')->constrained('conversaciones')->onDelete('cascade');
            $table->foreignId('id_remitente')->constrained('users')->onDelete('cascade');
            $table->text('mensaje');
            $table->enum('tipo_mensaje', ['texto', 'imagen', 'archivo'])->default('texto');
            $table->boolean('leido')->default(false);
            $table->timestamps();
            
            $table->index(['id_conversacion', 'created_at']);
            $table->index('leido');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};