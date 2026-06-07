<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisualizacionHistoria extends Model
{
    protected $table = 'visualizaciones_historia';

    protected $fillable = [
        'historia_id',
        'usuario_id',
        'fecha_visualizacion',
    ];

    protected $casts = [
        'fecha_visualizacion' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function historia()
    {
        return $this->belongsTo(Historia::class, 'historia_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}