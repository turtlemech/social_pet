<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    // Usuario creador
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Ubicación
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion');
    }

    // Participantes
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
}