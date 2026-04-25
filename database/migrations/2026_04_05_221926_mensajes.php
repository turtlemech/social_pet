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
            $table->string('cod_mens', 8)->unique();
            $table->foreignId('con_id')
                ->constrained('conversaciones')
                ->onDelete('cascade');
            $table->foreignId('us_rem')
                ->constrained('usuarios')
                ->onDelete('cascade');
            $table->text('men_mens');
            $table->enum('tip_mens', ['texto', 'imagen'])->default('texto');
            $table->string('url_mens', 255)->nullable();
            $table->boolean('lei_mens')->default(false);
            $table->timestamp('fch_lei_mens')->nullable(); // Cambiado a timestamp
            $table->timestamps();
            
            $table->index(['con_id', 'created_at'], 'mensajes_conversacion_fecha_idx');
            $table->index('us_rem', 'mensajes_remitente_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};