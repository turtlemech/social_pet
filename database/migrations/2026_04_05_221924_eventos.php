<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ubicacion', function (Blueprint $table) {
            $table->id(); 

            $table->string('nom_ubi', 150)->nullable();
            $table->string('ciu_ubi', 100)->nullable();
            $table->string('pai_ubi', 100)->nullable();
            $table->timestamps();
        });
        
        Schema::create('eventos', function (Blueprint $table) {
    $table->id();

    $table->string('nom_eve', 100);

    $table->text('des_eve')->nullable();

    $table->dateTime('fch_eve');

    $table->foreignId('usuario_id')
        ->constrained('usuarios')
        ->onDelete('cascade');

    $table->foreignId('id_ubicacion')
        ->nullable()
        ->constrained('ubicacion')
        ->onDelete('set null');

    $table->timestamps();
});

        // Tabla pivote para la relación de Muchos a Muchos (Usuarios <-> Eventos)
        Schema::create('participacion_evento', function (Blueprint $table) {
            $table->id();
            $table->enum('est_par', ['aceptada', 'rechazada','en espera'])->default('aceptada');
            

            $table->foreignId('evento_id')->constrained('eventos')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->unique(['evento_id', 'usuario_id'], 'user_evento_unique');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Eliminadas en orden inverso por las claves foráneas
        Schema::dropIfExists('participacion_evento');
        Schema::dropIfExists('eventos');
        Schema::dropIfExists('ubicacion');
    }
};