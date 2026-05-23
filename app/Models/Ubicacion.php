<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'ubicacion';

    protected $fillable = [
        'nom_ubi',
        'latitud',
        'longitud',
    ];

    public function eventos()
    {
        return $this->hasMany(Evento::class, 'id_ubicacion');
    }
}