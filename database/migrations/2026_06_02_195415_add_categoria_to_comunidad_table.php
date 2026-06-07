<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comunidad', function (Blueprint $table) {

            $table->string('cat_com')
                  ->nullable()
                  ->after('pri_com');

        });
    }

    public function down(): void
    {
        Schema::table('comunidad', function (Blueprint $table) {

            $table->dropColumn('cat_com');

        });
    }
};