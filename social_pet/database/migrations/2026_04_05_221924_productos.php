<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('cod_pro', 8)->unique();
            $table->string('nom_pro', 150);
            $table->text('des_pro')->nullable();
            $table->decimal('pre_pro', 10, 2);
            $table->string('cat_pro', 100)->nullable();
            $table->integer('sto_pro')->default(1);
            $table->text('img_pro')->nullable();
            $table->foreignId('us_ven')->constrained('usuarios')->onDelete('cascade');
            $table->timestamps();
            
            $table->index('cat_pro', 'productos_categoria_idx');
            $table->index('pre_pro', 'productos_precio_idx');
            $table->index('nom_pro', 'productos_nombre_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};