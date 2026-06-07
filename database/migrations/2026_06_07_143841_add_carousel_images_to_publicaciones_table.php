<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('publicaciones', function (Blueprint $table) {

            $table->string('img_pub_2')->nullable()->after('img_pub');

            $table->string('img_pub_3')->nullable()->after('img_pub_2');

            $table->string('img_pub_4')->nullable()->after('img_pub_3');

            $table->string('img_pub_5')->nullable()->after('img_pub_4');

        });
    }

    public function down(): void
    {
        Schema::table('publicaciones', function (Blueprint $table) {

            $table->dropColumn([
                'img_pub_2',
                'img_pub_3',
                'img_pub_4',
                'img_pub_5'
            ]);

        });
    }
};