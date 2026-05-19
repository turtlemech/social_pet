<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $table = 'mensajes';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'cod_mens',
        'con_men',
        'url_men',
        'tip_men',
        'lei_mens',
        'fch_lei_mens',
        'con_id',
        'us_rem',
    ];

    protected $casts = [
        'lei_mens' => 'boolean',
        'fch_lei_mens' => 'datetime',
    ];

    // Relaciones
    public function conversacion()
    {
        return $this->belongsTo(Conversacion::class, 'con_id');
    }

    public function remitente()
    {
        return $this->belongsTo(User::class, 'us_rem');
    }

    // Métodos
    public function marcarComoLeido()
    {
        $this->lei_mens = true;
        $this->fch_lei_mens = now();
        return $this->save();
    }
}