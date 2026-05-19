<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    use HasFactory;

    protected $table = 'participantes';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'cod_par',
        'con_id',
        'us_id',
        'fch_uni_par',
        'fch_sal_par',
    ];

    // Relaciones
    public function conversacion()
    {
        return $this->belongsTo(Conversacion::class, 'con_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'us_id');
    }
}