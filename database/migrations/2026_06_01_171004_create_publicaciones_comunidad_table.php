<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publicaciones_comunidad', function (Blueprint $table) {

            $table->id();

            $table->integer('cod_com');

            $table->unsignedBigInteger('id_usuario');

            $table->text('contenido')->nullable();

            $table->string('imagen')->nullable();

            $table->string('tipo')->default('texto');

            $table->integer('likes')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publicaciones_comunidad');
    }
};