<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'cod_us',
        'nom_us',
        'app_us',
        'apm_us',
        'ema_us',
        'pas_us',
        'tel_us',
        'ubi_us',
        'ava_us',
        'tip_us',
        'est_us',
        'is_admin',
    ];

    protected $hidden = [
        'pas_us',
        'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    // Relaciones con todos los modelos
    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'usuario_id');
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'us_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_usuario');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'id_usuario');
    }

    public function amistadesEnviadas()
    {
        return $this->hasMany(Amistad::class, 'us_sol');
    }

    public function amistadesRecibidas()
    {
        return $this->hasMany(Amistad::class, 'us_rec');
    }

    public function conversaciones()
    {
        return $this->belongsToMany(Conversacion::class, 'participantes', 'us_id', 'con_id')
                    ->withPivot('cod_par', 'fch_uni_par', 'fch_sal_par')
                    ->withTimestamps();
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'us_rem');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'usuario_id');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class, 'us_ven');
    }

    public function adopcionesActivas()
    {
        return $this->hasMany(Adopcion::class, 'us_act');
    }

    public function adopcionesSolicitadas()
    {
        return $this->hasMany(Adopcion::class, 'us_sol');
    }

    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'participacion_evento', 'usuario_id', 'evento_id')
                    ->withPivot('est_par')
                    ->withTimestamps();
    }

    public function ticketsSoporte()
    {
        return $this->hasMany(Soporte::class, 'cod_us', 'cod_us');
    }

    public function reportesHechos()
    {
        return $this->hasMany(soporte::class, 'usu_reporta_id');
    }

    public function reportesRecibidos()
    {
        return $this->hasMany(soporte::class, 'usu_reportado_id');
    }

    // Métodos útiles
    public function isAdmin()
    {
        return $this->is_admin === true || $this->tip_us === 'admin';
    }

    public function isActive()
    {
        return $this->est_us === 'activo';
    }
}