<?php

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
            $table->unsignedBigInteger('mas_id');
            $table->unsignedBigInteger('us_act');
            $table->unsignedBigInteger('us_sol')->nullable();
            $table->timestamp('fch_sol_ado')->nullable();
            $table->timestamps();
            
            // Llaves foráneas
            $table->foreign('mas_id')->references('id')->on('mascotas')->onDelete('cascade');
            $table->foreign('us_act')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('us_sol')->references('id')->on('usuarios')->onDelete('set null');
            
            // Índices
            $table->index('est_ado');
            $table->index(['mas_id', 'est_ado']);
            $table->index('us_act');
            $table->index('us_sol');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adopciones');
    }
};