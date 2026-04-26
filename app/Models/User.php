<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'cod_us',
        'nom_us',
        'ema_us',
        'pas_us',
        'tel_us',
        'ciu_us',
        'ava_us',
        'estado',      // ← Agregado: campo para activo/inactivo
        'is_admin',
    ];

    protected $hidden = [
        'pas_us',
        'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    // ✅ Usar 'id' para la autenticación (requerido para sesiones)
    public function getAuthIdentifierName()
    {
        return 'id';  // Cambiado de 'ema_us' a 'id'
    }

    public function getAuthPassword()
    {
        return $this->pas_us;
    }

    public function getEmailForPasswordReset()
    {
        return $this->ema_us;
    }
    
    // Método para encontrar usuario por email (útil para login)
    public static function findByEmail($email)
    {
        return self::where('ema_us', $email)->first();
    }
    
    // Desactivar usuario (cambia estado a inactivo)
    public function deactivate()
    {
        $this->estado = 'inactivo';
        return $this->save();
    }
    
    // Reactivar usuario (cambia estado a activo)
    public function activate()
    {
        $this->estado = 'activo';
        return $this->save();
    }
    
    // Verificar si el usuario está activo
    public function isActive()
    {
        return $this->estado === 'activo';
    }
    
    // Verificar si el usuario está inactivo
    public function isInactive()
    {
        return $this->estado === 'inactivo';
    }
    
    // Scope para usuarios activos
    public function scopeActive($query)
    {
        return $query->where('estado', 'activo');
    }
    
    // Scope para usuarios inactivos
    public function scopeInactive($query)
    {
        return $query->where('estado', 'inactivo');
    }
}