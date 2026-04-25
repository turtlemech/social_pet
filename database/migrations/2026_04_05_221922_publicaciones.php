<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->string('cod_pub', 8)->unique();
            $table->text('con_pub');
            $table->text('img_pub')->nullable();
            $table->foreignId('us_id')->constrained('usuarios')->onDelete('cascade');
            $table->timestamps();
            
            $table->index('us_id', 'publicaciones_usuario_idx');
            $table->index('created_at', 'publicaciones_fecha_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};