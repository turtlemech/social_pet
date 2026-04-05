<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->enum('especie', ['perro', 'gato', 'ave', 'roedor', 'reptil', 'otros']);
            $table->string('raza', 100)->nullable();
            $table->integer('edad')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo', ['macho', 'hembra']);
            $table->decimal('peso', 5, 2)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('foto_perfil', 255)->nullable();
            $table->text('caracteristicas')->nullable();
            $table->boolean('esterilizado')->default(false);
            $table->text('vacunas')->nullable();
            $table->text('alergias')->nullable();
            $table->timestamps();
            
            $table->index(['id_usuario', 'especie'], 'mascotas_user_especie_idx');
            $table->index('nombre', 'mascotas_nombre_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};