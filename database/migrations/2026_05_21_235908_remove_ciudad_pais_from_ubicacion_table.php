<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ubicacion', function (Blueprint $table) {

            $table->dropColumn([
                'ciu_ubi',
                'pai_ubi'
            ]);

        });
    }

    public function down(): void
    {
        Schema::table('ubicacion', function (Blueprint $table) {

            $table->string('ciu_ubi')->nullable();
            $table->string('pai_ubi')->nullable();

        });
    }
};