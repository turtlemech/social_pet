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
}