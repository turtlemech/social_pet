<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reacciones', function (Blueprint $table) {
            $table->id();
            $table->string('cod_rea')->nullable();
            $table->enum('tip_rea', ['like', 'love', 'wow', 'triste', 'enojado']);
            
            
            $table->foreignId('id_publicacion')->constrained('publicaciones');
            $table->foreignId('id_usuario')->constrained('usuarios');
            
            $table->timestamps();
            
            $table->unique(['id_publicacion', 'id_usuario'], 'reacciones_unique');
            $table->index('tip_rea', 'reacciones_tipo_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reacciones');
    }
};