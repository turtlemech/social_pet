<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('valoraciones', function (Blueprint $table) {
            $table->id();
            $table->string('cod_val', 8)->unique();
            $table->integer('pun_val')->check('pun_val BETWEEN 1 AND 5');
            $table->text('com_val')->nullable();
            $table->foreignId('pro_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('us_com')->constrained('usuarios')->onDelete('cascade');
            $table->timestamps();
            
            $table->index('pun_val', 'valoraciones_puntuacion_idx');
            $table->index(['pro_id', 'pun_val'], 'valoraciones_producto_puntuacion_idx');
            $table->unique(['pro_id', 'us_com'], 'valoraciones_unique_valoracion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('valoraciones');
    }
};