<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentarios_comunidad', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('publicacion_id');

            $table->unsignedBigInteger('id_usuario');

            $table->text('comentario');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios_comunidad');
    }
};