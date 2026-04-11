<?php
// database/migrations/2024_01_01_000009_create_adopciones_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adopciones', function (Blueprint $table) {
            $table->id();
            $table->string('cod_ado', 8)->unique();
            $table->enum('est_ado', ['disponible', 'en_proceso', 'adoptada', 'cancelada'])->default('disponible');
            $table->text('men_ado')->nullable();
            $table->foreignId('mas_id')->constrained('mascotas')->onDelete('cascade');
            $table->foreignId('us_act')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('us_sol')->nullable()->constrained('usuarios')->onDelete('set null');
            $table->datetime('fch_sol_ado')->nullable();
            $table->timestamps();
            
            $table->index('est_ado', 'adopciones_estado_idx');
            $table->index(['mas_id', 'est_ado'], 'adopciones_mascota_estado_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adopciones');
    }
};