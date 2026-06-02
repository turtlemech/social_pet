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
            $table->string('app_us', 100); // Apellido Paterno
            $table->string('apm_us', 100); // Apellido Materno
            $table->string('ema_us', 150)->unique();
            $table->string('pas_us', 255);
            $table->string('tel_us', 20)->nullable();
            
            $table->string('ubi_us', 100)->nullable();
            $table->enum('tip_us', ['admin', 'soporte','usuario' ])->default('usuario');
            $table->enum('est_us', ['activo', 'inactivo', 'baneado'])->default('activo');
            
            $table->text('ava_us')->nullable();
            $table->rememberToken();
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
            
            // Índices corregidos
            $table->index('nom_us', 'usuarios_nombre_idx');
            $table->index('app_us', 'usuarios_app_idx');
            $table->index('apm_us', 'usuarios_apm_idx'); 
            
            $table->index('est_us', 'usuarios_estado_idx');          
            $table->index('is_admin', 'usuarios_admin_idx');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            // Cambiado a un campo común o puedes usar foreignId('usuario_id') si prefieres enlazarlo formalmente
            $table->unsignedBigInteger('user_id')->nullable()->index(); 
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
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('usuarios');
    }
};