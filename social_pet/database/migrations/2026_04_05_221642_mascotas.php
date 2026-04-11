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
            $table->string('cod_mas', 8)->unique();
            $table->string('nom_mas', 100);
            $table->string('esp_mas', 50);
            $table->string('raz_mas', 100)->nullable();
            $table->integer('ed_mas')->nullable();
            $table->decimal('pes_mas', 5, 2)->nullable();
            $table->text('fot_mas')->nullable();
            $table->foreignId('us_id')->constrained('usuarios')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['us_id', 'esp_mas'], 'mascotas_user_especie_idx');
            $table->index('nom_mas', 'mascotas_nombre_idx');
        });
    }

/**
 * Reverse the effect of the up method.
 */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
