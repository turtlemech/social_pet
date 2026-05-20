<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';
    
    protected $fillable = [
        'nom_eve',
        'des_eve',
        'fch_eve',
        'id_ubicacion',
    ];

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion');
    }

    public function asistentes()
    {
        return $this->belongsToMany(User::class, 'participacion_evento', 'evento_id', 'usuario_id')
                    ->withPivot('est_par')
                    ->withTimestamps();
    }
}