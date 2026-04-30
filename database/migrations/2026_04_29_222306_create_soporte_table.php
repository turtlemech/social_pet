<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soporte', function (Blueprint $table) {
            $table->id();
            $table->string('cod_sop', 12)->unique(); // Código único del ticket ej: SPT202401010001
            $table->string('cod_us', 8); // Relación con usuarios.cod_us
            $table->string('asu_sop', 200); // Asunto
            $table->enum('cat_sop', ['tecnico', 'cuenta', 'mascota', 'pago', 'otro']); // Categoría
            $table->enum('pri_sop', ['baja', 'media', 'alta', 'urgente'])->default('media'); // Prioridad
            $table->text('men_sop'); // Mensaje
            $table->enum('est_sop', ['abierto', 'en_proceso', 'resuelto', 'cerrado'])->default('abierto'); // Estado
            $table->text('res_sop')->nullable(); // Respuesta del administrador
            $table->string('cod_admin', 8)->nullable(); // Código del admin que atendió
            $table->timestamp('fec_resuelto')->nullable(); // Fecha de resolución
            $table->timestamps();
            
            // Índices
            $table->index('cod_sop', 'soporte_cod_idx');
            $table->index('cod_us', 'soporte_usuario_idx');
            $table->index('est_sop', 'soporte_estado_idx');
            $table->index('pri_sop', 'soporte_prioridad_idx');
            $table->index('created_at', 'soporte_fecha_idx');
            
            // Foreign key
            $table->foreign('cod_us')->references('cod_us')->on('usuarios')->onDelete('cascade');
            $table->foreign('cod_admin')->references('cod_us')->on('usuarios')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soporte');
    }
};