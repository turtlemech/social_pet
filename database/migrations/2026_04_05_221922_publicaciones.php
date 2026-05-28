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

            $table->text('com_pub')->nullable();
            $table->text('img_pub')->nullable();
            $table->foreignId('us_id')->constrained('usuarios');
            $table->enum('est_pub', ['activo', 'inactivo',])->default('activo');
            $table->timestamps();

            $table->index('us_id', 'publicaciones_usuario_idx');
            $table->index('created_at', 'publicaciones_fecha_idx');
        });

        Schema::create('multimedia', function (Blueprint $table) {
            $table->id();
            $table->string('nom_mul', 150);
            $table->string('art_mul', 100)->nullable();
            $table->string('gen_mul', 50)->nullable();
            $table->unsignedInteger('dur_mul')->nullable();
            $table->string('url_mul');

            $table->enum('tip_mul', ['audio', 'video']);

            $table->timestamps();

            $table->index('art_mul', 'mul_art_idx');
            $table->index('gen_mul', 'mul_gen_idx');
            $table->index('tip_mul', 'mul_tip_idx'); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('multimedia');
        Schema::dropIfExists('publicaciones');
    }
};
