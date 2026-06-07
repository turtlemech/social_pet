<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HistoriaDestacada;

class Historia extends Model
{
    protected $table = 'historias';

    protected $fillable = [
        'usuario_id',
        'media',
        'tipo',
        'musica',
        'descripcion',
        'texto_alternativo',
        'elementos',
        'es_destacada',
        'fecha_expiracion',
    ];

    protected $casts = [
        'elementos' => 'array',
        'es_destacada' => 'boolean',
        'fecha_expiracion' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function visualizaciones()
    {
        return $this->hasMany(VisualizacionHistoria::class, 'historia_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActivas($query)
    {
        return $query->where('fecha_expiracion', '>', now());
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS AUXILIARES
    |--------------------------------------------------------------------------
    */

    public function estaActiva()
    {
        return $this->fecha_expiracion > now();
    }

    public function fueVistaPor($usuarioId)
    {
        return $this->visualizaciones()
            ->where('usuario_id', $usuarioId)
            ->exists();
    }

    public function totalVisualizaciones()
    {
        return $this->visualizaciones()->count();
    }
    public function destacadas()
{
    return $this->belongsToMany(
        HistoriaDestacada::class,
        'historia_destacada_historia',
        'historia_id',
        'historia_destacada_id'
    );
}
}