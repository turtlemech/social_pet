<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historia_destacada_historia', function (Blueprint $table) {

            $table->id();

            $table->foreignId('historia_destacada_id')
                ->constrained('historias_destacadas')
                ->cascadeOnDelete();

            $table->foreignId('historia_id')
                ->constrained('historias')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historia_destacada_historia');
    }
};