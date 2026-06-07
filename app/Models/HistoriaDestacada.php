<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriaDestacada extends Model
{
    protected $table = 'historias_destacadas';

    protected $fillable = [
        'usuario_id',
        'titulo',
        'portada'
    ];

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'usuario_id'
        );
    }

    public function historias()
    {
        return $this->belongsToMany(
            Historia::class,
            'historia_destacada_historia',
            'historia_destacada_id',
            'historia_id'
        );
    }
}