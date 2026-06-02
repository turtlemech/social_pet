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
            $table->enum('cat_pro', ['alimento', 'juguete', 'accesorio', 'ropa', 'salud', 'otro'])->nullable();
            $table->enum('est_pro', ['activo', 'inactivo',])->default('activo');
            $table->text('img_pro')->nullable();
            $table->foreignId('us_ven')->constrained('usuarios');
            $table->timestamps();
            
            $table->index('cat_pro', 'prod_cat_idx');
            $table->index('pre_pro', 'prod_pre_idx');
            $table->index('nom_pro', 'prod_nom_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};