<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historias', function (Blueprint $table) {

            $table->id();

            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->cascadeOnDelete();

            $table->string('media');

            $table->enum('tipo', [
                'imagen',
                'video'
            ])->default('imagen');

            $table->string('musica')->nullable();

            $table->text('descripcion')->nullable();

            $table->text('texto_alternativo')->nullable();

            $table->json('elementos')->nullable();

            $table->boolean('es_destacada')
                ->default(false);

            $table->timestamp('fecha_expiracion');

            $table->timestamps();

            $table->index('usuario_id');
            $table->index('fecha_expiracion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historias');
    }
};