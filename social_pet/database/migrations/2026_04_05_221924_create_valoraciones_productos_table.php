<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('valoraciones_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_producto')->constrained('productos')->onDelete('cascade');
            $table->foreignId('id_usuario_comprador')->constrained('users')->onDelete('cascade');
            $table->integer('calificacion');
            $table->text('comentario')->nullable();
            $table->timestamps();
            
            $table->unique(['id_producto', 'id_usuario_comprador'], 'val_productos_unique');
            $table->index('calificacion', 'val_productos_calif_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('valoraciones_productos');
    }
};