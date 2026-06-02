<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {

            $table->id();
            $table->text('con_com')->nullable();

            $table->foreignId('id_publicacion')->constrained('publicaciones');

            $table->foreignId('id_usuario')->constrained('usuarios');
            $table->enum('estado', ['activo', 'eliminado']);

            $table->timestamps();
            $table->index(['id_publicacion', 'created_at'],'comentarios_pub_date_idx');

            $table->index( 'id_usuario', 'comentarios_user_idx' );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};