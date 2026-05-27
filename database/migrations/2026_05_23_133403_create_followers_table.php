<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seguidores', function (Blueprint $table) {

            $table->id();

            // usuario que sigue
            $table->foreignId('us_seg')
                ->constrained('usuarios')
                ->onDelete('cascade');

            // usuario seguido
            $table->foreignId('us_sig')
                ->constrained('usuarios')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique([
                'us_seg',
                'us_sig'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seguidores');
    }
};