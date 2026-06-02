<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipacionEvento extends Model
{
    protected $table = 'participacion_evento';

    protected $fillable = [
        'evento_id',
        'usuario_id',
        'est_par',
    ];
}