<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conversaciones', function (Blueprint $table) {

            $table->enum('tipo', [
                'normal',
                'adopcion',
                'marketplace'
            ])->default('normal');

            $table->unsignedBigInteger('adopcion_id')
                  ->nullable();

            $table->unsignedBigInteger('producto_id')
                  ->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('conversaciones', function (Blueprint $table) {

            $table->dropColumn([
                'tipo',
                'adopcion_id',
                'producto_id'
            ]);

        });
    }
};