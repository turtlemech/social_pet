<?php
// database/migrations/2024_01_01_000011_create_participantes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();
            $table->string('cod_par', 8)->unique();
            $table->foreignId('con_id')->constrained('conversaciones')->onDelete('cascade');
            $table->foreignId('us_id')->constrained('usuarios')->onDelete('cascade');
            $table->datetime('fch_uni_par')->useCurrent();
            $table->datetime('fch_sal_par')->nullable();
            $table->timestamps();
            
            $table->unique(['con_id', 'us_id'], 'participante_unique');
            $table->index('us_id', 'participantes_usuario_idx');
            $table->index('con_id', 'participantes_conversacion_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};