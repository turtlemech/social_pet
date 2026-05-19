<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->string('cod_mens', 8)->unique();
            $table->text('con_men')->nullable();
            $table->string('url_men')->nullable();
            $table->enum('tip_men', ['texto', 'imagen', 'video', 'audio'])->default('texto'); // Añadido default

            $table->boolean('lei_mens')->default(false);
            $table->timestamp('fch_lei_mens')->nullable();

            $table->foreignId('con_id')->constrained('conversaciones'); // ✓ OK
            $table->foreignId('us_rem')->constrained('usuarios'); // ✓ OK

            $table->timestamps();

            $table->index(['con_id', 'created_at'], 'mens_con_fecha_idx');
            $table->index('us_rem', 'mensajes_remitente_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};
