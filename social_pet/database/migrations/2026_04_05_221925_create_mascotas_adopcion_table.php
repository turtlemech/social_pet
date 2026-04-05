<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mascotas_adopcion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_protectora')->constrained('users')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->enum('especie', ['perro', 'gato', 'ave', 'roedor', 'reptil', 'otros']);
            $table->string('raza', 100)->nullable();
            $table->integer('edad')->nullable();
            $table->enum('sexo', ['macho', 'hembra']);
            $table->enum('tamanio', ['pequeño', 'mediano', 'grande']);
            $table->text('descripcion')->nullable();
            $table->text('requisitos_adopcion')->nullable();
            $table->text('fotos')->nullable();
            $table->enum('estado_adopcion', ['disponible', 'en_proceso', 'adoptado', 'no_disponible'])->default('disponible');
            $table->timestamp('fecha_adopcion')->nullable();
            $table->timestamps();
            
            $table->index(['especie', 'tamanio']);
            $table->index('estado_adopcion');
            $table->index('nombre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascotas_adopcion');
    }
};