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

            $table->foreignId('us_sol')->constrained('usuarios');
            $table->foreignId('us_rec')->constrained('usuarios');
            $table->timestamps();
            
            $table->index(['us_sol', 'est_ami'], 'amistades_solicitante_estado_idx');
            $table->index(['us_rec', 'est_ami'], 'amistades_receptor_estado_idx');
            $table->unique(['us_sol', 'us_rec'], 'amistades_unique_solicitud');
        });

        Schema::create('solicitud_amistad', function (Blueprint $table) {
            $table->id();
            $table->enum('est_sol', ['pendiente', 'aceptada', 'rechazada', 'cancelada'])->default('pendiente');
            $table->foreignId('usuario_emisor_id')->constrained('usuario');
            $table->foreignId('usuario_receptor_id')->constrained('usuario');
            $table->unique(['usuario_emisor_id', 'usuario_receptor_id']);
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('amistades');
        Schema::dropIfExists('solicitud_amistad');
    }
};