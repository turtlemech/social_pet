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
        'ape_us',
        'ema_us',
        'pas_us',
        'tel_us',
        'ubi_us',
        'ciu_us',
        'ava_us',
        'tip_us',
        'est_us',
        'estado',
        'is_admin',
    ];

    protected $hidden = [
        'pas_us',
        'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    public function getAuthPassword()
    {
        return $this->pas_us;
    }

    // ================= MASCOTAS =================

    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'usuario_id');
    }

    // ================= PUBLICACIONES =================

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

    // ================= AMISTADES =================

    public function amistadesEnviadas()
    {
        return $this->hasMany(Amistad::class, 'us_sol');
    }

    public function amistadesRecibidas()
    {
        return $this->hasMany(Amistad::class, 'us_rec');
    }

    // ================= MENSAJES =================

    public function conversaciones()
    {
        return $this->belongsToMany(
            Conversacion::class,
            'participantes',
            'us_id',
            'con_id'
        )
        ->withPivot(
            'cod_par',
            'fch_uni_par',
            'fch_sal_par'
        )
        ->withTimestamps();
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'us_rem');
    }

    // ================= NOTIFICACIONES =================

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'usuario_id');
    }

    // ================= PRODUCTOS =================

    public function productos()
    {
        return $this->hasMany(Producto::class, 'us_ven');
    }

    // ================= ADOPCIONES =================

    public function adopcionesActivas()
    {
        return $this->hasMany(Adopcion::class, 'us_act');
    }

    public function adopcionesSolicitadas()
    {
        return $this->hasMany(Adopcion::class, 'us_sol');
    }

    // ================= EVENTOS =================

    public function eventosCreados()
    {
        return $this->hasMany(Evento::class, 'usuario_id');
    }

    public function eventosParticipando()
    {
        return $this->belongsToMany(
            Evento::class,
            'participacion_evento',
            'usuario_id',
            'evento_id'
        )->withPivot('est_par');
    }

    // ================= SOPORTE =================

    public function ticketsSoporte()
    {
        return $this->hasMany(
            Soporte::class,
            'cod_us',
            'cod_us'
        );
    }

    public function reportesHechos()
    {
        return $this->hasMany(
            Soporte::class,
            'usu_reporta_id'
        );
    }

    public function reportesRecibidos()
    {
        return $this->hasMany(
            Soporte::class,
            'usu_reportado_id'
        );
    }

    // ================= SEGUIDORES =================

    public function seguidores()
    {
        return $this->belongsToMany(
            User::class,
            'seguidores',
            'us_sig',
            'us_seg'
        );
    }

    public function siguiendo()
    {
        return $this->belongsToMany(
            User::class,
            'seguidores',
            'us_seg',
            'us_sig'
        );
    }

    public function sigueA($userId)
    {
        return $this->siguiendo()
            ->where('us_sig', $userId)
            ->exists();
    }

    // ================= MASCOTAS SEGUIDAS =================

    public function mascotasSeguidas()
    {
        return $this->belongsToMany(
            Mascota::class,
            'seguimiento_mascota',
            'us_seg',
            'mas_seg'
        )->withTimestamps();
    }

    // ================= MÉTODOS ÚTILES =================

    public function isAdmin()
    {
        return $this->is_admin === true
            || $this->tip_us === 'admin';
    }

    public function isActive()
    {
        return $this->est_us === 'activo'
            || $this->estado === 'activo';
    }
}