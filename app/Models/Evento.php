<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Ubicacion;
use App\Models\Mascota;

class Evento extends Model
{
    protected $table = 'eventos';

    protected $fillable = [
        'nom_eve',
        'des_eve',
        'img_eve',
        'cat_eve',
        'est_eve',
        'destacado',
        'capacidad_eve',
        'fch_eve',
        'usuario_id',
        'id_ubicacion',
    ];

    protected $casts = [
        'fch_eve' => 'datetime',
        'destacado' => 'boolean',
    ];

    // ================= USUARIO CREADOR =================

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'usuario_id'
        );
    }

    // ================= UBICACIÓN =================

    public function ubicacion()
    {
        return $this->belongsTo(
            Ubicacion::class,
            'id_ubicacion'
        );
    }

    // ================= PARTICIPANTES (USUARIOS) =================

    public function participantes()
    {
        return $this->belongsToMany(
            User::class,
            'participacion_evento',
            'evento_id',
            'usuario_id'
        )
        ->withPivot('est_par')
        ->withTimestamps();
    }

    // ================= MASCOTAS PARTICIPANTES =================

    public function mascotasParticipantes()
    {
        return $this->belongsToMany(
            Mascota::class,
            'mascotas_evento',
            'evento_id',
            'mascota_id'
        )->withTimestamps();
    }
}