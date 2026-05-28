<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {

            $table->id();

            $table->string('cod_not')->nullable();

            $table->string('tit_not');

            $table->text('men_not');

            $table->string('tip_not')->nullable();

            $table->boolean('lei_not')->default(false);

            $table->timestamp('fch_lei_not')->nullable();

            $table->unsignedBigInteger('usuario_id');

            $table->string('url_not')->nullable();

            $table->timestamps();

            // FK
            $table->foreign('usuario_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};