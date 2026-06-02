<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seguimiento_mascota', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('us_seg');

            $table->unsignedBigInteger('mas_seg');

            $table->timestamps();

            // FOREIGN KEYS

            $table->foreign('us_seg')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');

            $table->foreign('mas_seg')
                ->references('id')
                ->on('mascotas')
                ->onDelete('cascade');

            // EVITAR DUPLICADOS

            $table->unique([
                'us_seg',
                'mas_seg'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seguimiento_mascota');
    }
};