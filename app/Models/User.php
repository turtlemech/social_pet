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
        'ape_us',
        'ema_us',
        'pas_us',
        'tel_us',
        'ciu_us',
        'ava_us',
        'estado',
        'is_admin',
    ];

    protected $hidden = [
        'pas_us',
        'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'estado' => 'string',
    ];

    /**
     * Obtener el identificador para autenticación
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Obtener la contraseña para autenticación
     */
    public function getAuthPassword()
    {
        return $this->pas_us;
    }

    /**
     * Obtener el email para reseteo de contraseña
     */
    public function getEmailForPasswordReset()
    {
        return $this->ema_us;
    }
    
    /**
     * Accessor: Obtener nombre completo
     */
    public function getFullNameAttribute()
    {
        return trim($this->nom_us . ' ' . $this->ape_us);
    }
    
    /**
     * Accessor: Obtener iniciales para avatar
     */
    public function getInitialsAttribute()
    {
        $first = strtoupper(substr($this->nom_us, 0, 1));
        $last = strtoupper(substr($this->ape_us, 0, 1));
        return $first . $last;
    }
    
    /**
     * Mutator: Guardar teléfono limpio (solo números)
     */
    public function setTelUsAttribute($value)
    {
        $this->attributes['tel_us'] = $value ? preg_replace('/[^0-9]/', '', $value) : null;
    }
    
    /**
     * Mutator: Guardar ciudad con primera letra mayúscula
     */
    public function setCiuUsAttribute($value)
    {
        $this->attributes['ciu_us'] = $value ? ucfirst(strtolower(trim($value))) : null;
    }
    
    // ========== MÉTODOS DE BÚSQUEDA ==========
    
    /**
     * Encontrar usuario por email
     */
    public static function findByEmail($email)
    {
        return self::where('ema_us', $email)->first();
    }
    
    /**
     * Buscar usuarios por nombre o apellido
     */
    public static function searchByName($search)
    {
        return self::where('nom_us', 'LIKE', "%{$search}%")
                    ->orWhere('ape_us', 'LIKE', "%{$search}%")
                    ->get();
    }
    
    // ========== MÉTODOS DE ESTADO ==========
    
    /**
     * Desactivar usuario
     */
    public function deactivate()
    {
        $this->estado = 'inactivo';
        return $this->save();
    }
    
    /**
     * Reactivar usuario
     */
    public function activate()
    {
        $this->estado = 'activo';
        return $this->save();
    }
    
    /**
     * Verificar si el usuario está activo
     */
    public function isActive()
    {
        return $this->estado === 'activo';
    }
    
    /**
     * Verificar si el usuario está inactivo
     */
    public function isInactive()
    {
        return $this->estado === 'inactivo';
    }
    
    /**
     * Verificar si es administrador
     */
    public function isAdmin()
    {
        return $this->is_admin === true;
    }
    
    // ========== SCOPES ==========
    
    /**
     * Scope para usuarios activos
     */
    public function scopeActive($query)
    {
        return $query->where('estado', 'activo');
    }
    
    /**
     * Scope para usuarios inactivos
     */
    public function scopeInactive($query)
    {
        return $query->where('estado', 'inactivo');
    }
    
    /**
     * Scope para administradores
     */
    public function scopeAdmins($query)
    {
        return $query->where('is_admin', true);
    }
    
    /**
     * Scope para usuarios normales (no administradores)
     */
    public function scopeRegular($query)
    {
        return $query->where('is_admin', false);
    }
    
    
}