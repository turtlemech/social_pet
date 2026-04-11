<?php
// database/migrations/2024_01_01_000010_create_conversaciones_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversaciones', function (Blueprint $table) {
            $table->id();
            $table->string('cod_con', 8)->unique();
            $table->enum('tip_con', ['individual', 'grupal'])->default('individual');
            $table->string('nom_con', 100)->nullable();
            $table->foreignId('us_crea')->constrained('usuarios')->onDelete('cascade');
            $table->datetime('fch_act_con')->nullable();
            $table->boolean('act_con')->default(true);
            $table->timestamps();
            
            $table->index('tip_con', 'conversaciones_tipo_idx');
            $table->index('us_crea', 'conversaciones_creador_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversaciones');
    }
};