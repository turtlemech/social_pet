<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('soporte', function (Blueprint $table) {
    $table->id();
    $table->string('cod_sop', 12)->unique(); 
    $table->string('cod_us', 8); 
    $table->string('asu_sop', 200); 
    $table->enum('cat_sop', ['tecnico', 'cuenta', 'mascota', 'pago', 'otro']); 
    $table->enum('pri_sop', ['baja', 'media', 'alta', 'urgente'])->default('media'); 
    $table->text('men_sop'); 
    $table->enum('est_sop', ['abierto', 'en_proceso', 'resuelto', 'cerrado'])->default('abierto'); 
    $table->text('res_sop')->nullable(); 
    $table->string('cod_admin', 8)->nullable(); 
    $table->timestamp('fec_resuelto')->nullable(); 
    $table->timestamps();
    
    // fk
    $table->index('cod_us', 'soporte_usuario_idx');
    $table->index('est_sop', 'soporte_estado_idx');
    $table->index('pri_sop', 'soporte_prioridad_idx');
    $table->index('created_at', 'soporte_fecha_idx');
    
    $table->foreign('cod_us')->references('cod_us')->on('usuarios');
    $table->foreign('cod_admin')->references('cod_us')->on('usuarios');
});
    }

    
    public function down(): void
    {
        Schema::dropIfExists('soporte');
    }
};