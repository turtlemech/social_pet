<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('publicaciones', function (Blueprint $table) {

            $table->unsignedBigInteger('mascota_id')
                ->nullable();

            $table->foreign('mascota_id')
                ->references('id')
                ->on('mascotas')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publicaciones', function (Blueprint $table) {

            $table->dropForeign(['mascota_id']);

            $table->dropColumn('mascota_id');

        });
    }
};