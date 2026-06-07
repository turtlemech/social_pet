<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reacciones_historia', function (Blueprint $table) {

            $table->id();

            $table->foreignId('historia_id')
                ->constrained('historias')
                ->cascadeOnDelete();

            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->cascadeOnDelete();

            $table->string('reaccion');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reacciones_historia');
    }
};