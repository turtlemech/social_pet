<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario_reportante')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_usuario_reportado')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('id_publicacion_reportada')->nullable()->constrained('publicaciones')->onDelete('cascade');
            $table->string('motivo', 255);
            $table->text('descripcion')->nullable();
            $table->enum('estado_reporte', ['pendiente', 'revisado', 'resuelto'])->default('pendiente');
            $table->timestamps();
            
            $table->index('estado_reporte');
            $table->index(['id_usuario_reportante', 'created_at']);
            $table->index('motivo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};