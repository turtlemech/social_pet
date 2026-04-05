<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_organizador')->constrained('users')->onDelete('cascade');
            $table->string('titulo', 200);
            $table->text('descripcion')->nullable();
            $table->string('ubicacion', 255)->nullable();
            $table->text('direccion')->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->dateTime('fecha_evento');
            $table->integer('duracion')->nullable()->comment('duración en minutos');
            $table->enum('tipo_evento', ['paseo', 'parque', 'adiestramiento', 'veterinario', 'fiesta', 'otros']);
            $table->integer('aforo_maximo')->nullable();
            $table->decimal('precio', 10, 2)->default(0);
            $table->string('imagen', 255)->nullable();
            $table->enum('estado', ['activo', 'cancelado', 'finalizado'])->default('activo');
            $table->timestamps();
            
            $table->index(['fecha_evento', 'ciudad'], 'eventos_fecha_ciudad_idx');
            $table->index('tipo_evento', 'eventos_tipo_idx');
            $table->index('estado', 'eventos_estado_idx');
            $table->index('fecha_evento', 'eventos_fecha_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};