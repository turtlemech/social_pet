<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. TABLA DE ESPECIES GENERALES
        Schema::create('especies', function (Blueprint $table) {
            $table->id();
            $table->string('nom_esp', 50)->unique(); // Ej: "Perro", "Gato", "Ave", "Reptil", "Roedor"
            $table->string('raz_mas', 100)->nullable();
            $table->string('tam_mas', 100)->nullable();
            

            $table->timestamps();
        });

        // 2. TABLA DE MASCOTAS
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->string('nom_mas', 100);
            $table->enum('sex_mas', ['macho', 'hembra'])->nullable();
            $table->text('des_mas')->nullable();
            $table->string('fot_mas')->nullable();
            $table->enum('est_mas', ['activo', 'inactivo'])->default('activo');

            // Relación obligatoria con la especie general
            $table->foreignId('especie_id')->constrained('especies')->onDelete('restrict');
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the effect of the up method.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
        Schema::dropIfExists('especies');
    }
};
