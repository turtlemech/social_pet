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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('cod_us', 8)->unique();
            $table->string('nom_us', 100);
            $table->string('ape_us', 100);  
            $table->string('ema_us', 150)->unique();
            $table->string('pas_us', 255);
            $table->string('tel_us', 20)->nullable();
            $table->string('ciu_us', 100)->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->text('ava_us')->nullable();
            $table->rememberToken();
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
            
            // Índices
            $table->index('nom_us', 'usuarios_nombre_idx');
            $table->index('ape_us', 'usuarios_apellido_idx');  // ← AGREGADO: índice para apellido
            $table->index('ciu_us', 'usuarios_ciudad_idx');
            $table->index('estado', 'usuarios_estado_idx');     // ← AGREGADO: útil para filtrar activos/inactivos
            $table->index('is_admin', 'usuarios_admin_idx');    // ← AGREGADO: útil para filtrar admins
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};