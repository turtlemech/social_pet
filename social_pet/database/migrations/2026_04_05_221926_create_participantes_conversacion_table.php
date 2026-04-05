<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participantes_conversacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_conversacion')->constrained('conversaciones')->onDelete('cascade');
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['id_conversacion', 'id_usuario'], 'unique_participante');
            $table->index('id_usuario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participantes_conversacion');
    }
};