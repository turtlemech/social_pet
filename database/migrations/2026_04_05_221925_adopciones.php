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
            $table->text('des_ado')->nullable();
            $table->timestamp('fch_pub_ado')->useCurrent();
            $table->timestamp('fch_sol_ado')->useCurrent();
            $table->timestamp('fch_res_ado')->nullable();
            $table->enum('est_ado', ['pendiente', 'aprobada', 'rechazada'])->nullable();
            $table->unsignedBigInteger('mas_id');
            $table->unsignedBigInteger('us_act');
            $table->unsignedBigInteger('us_sol')->nullable();
            
            $table->timestamps();
            
            // Llaves foráneas
            $table->foreign('mas_id')->references('id')->on('mascotas');
            $table->foreign('us_act')->references('id')->on('usuarios');
            $table->foreign('us_sol')->references('id')->on('usuarios');
            
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