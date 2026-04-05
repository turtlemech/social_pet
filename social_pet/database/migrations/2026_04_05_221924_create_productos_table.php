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
            $table->foreignId('id_usuario_vendedor')->constrained('users')->onDelete('cascade');
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->enum('categoria', ['alimento', 'juguetes', 'accesorios', 'salud', 'higiene', 'ropa', 'otros']);
            $table->decimal('precio', 10, 2);
            $table->integer('stock')->default(1);
            $table->text('imagenes')->nullable();
            $table->enum('estado_producto', ['nuevo', 'usado', 'reacondicionado'])->default('nuevo');
            $table->boolean('disponibilidad')->default(true);
            $table->timestamps();
            
            $table->index('categoria', 'productos_categoria_idx');
            $table->index('precio', 'productos_precio_idx');
            $table->index('disponibilidad', 'productos_disponible_idx');
            $table->index('nombre', 'productos_nombre_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};