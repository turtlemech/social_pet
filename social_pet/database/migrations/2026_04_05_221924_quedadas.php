<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quedadas', function (Blueprint $table) {
            $table->id();
            $table->string('cod_que', 8)->unique();
            $table->string('tit_que', 150);
            $table->text('des_que')->nullable();
            $table->string('ubi_que', 255)->nullable();
            $table->integer('max_que')->default(20);
            $table->foreignId('us_org')->constrained('usuarios')->onDelete('cascade');
            $table->datetime('fini_que');
            $table->datetime('ffin_que')->nullable();
            $table->timestamps();
            
            $table->index('fini_que', 'quedadas_fecha_inicio_idx');
            $table->index('ubi_que', 'quedadas_ubicacion_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};