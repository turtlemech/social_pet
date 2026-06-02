<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'participacion_evento';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'est_par',
        'evento_id',
        'usuario_id',
    ];

    // Relaciones
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Scopes
    public function scopeConfirmadas($query)
    {
        return $query->where('est_par', 'aceptada');
    }
}