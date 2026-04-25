<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('amistades', function (Blueprint $table) {
            $table->id();
            $table->string('cod_ami', 8)->unique();
            $table->enum('est_ami', ['pendiente', 'aceptada', 'rechazada'])->default('pendiente');
            $table->foreignId('us_sol')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('us_rec')->constrained('usuarios')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['us_sol', 'est_ami'], 'amistades_solicitante_estado_idx');
            $table->index(['us_rec', 'est_ami'], 'amistades_receptor_estado_idx');
            $table->unique(['us_sol', 'us_rec'], 'amistades_unique_solicitud');
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('amistades');
    }
};