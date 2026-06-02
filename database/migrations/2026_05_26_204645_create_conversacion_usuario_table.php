<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversacion_usuario', function (Blueprint $table) {

            $table->id();

            $table->string('cod_conv_us', 10)->unique();

            $table->foreignId('con_id')
                ->constrained('conversaciones')
                ->onDelete('cascade');

            $table->foreignId('us_id')
                ->constrained('usuarios')
                ->onDelete('cascade');

            $table->boolean('act_conv_us')->default(true);

            $table->timestamps();

            $table->unique(
                ['con_id', 'us_id'],
                'conv_user_unique'
            );

            $table->index('con_id', 'conv_user_conversacion_idx');

            $table->index('us_id', 'conv_user_usuario_idx');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversacion_usuario');
    }
};