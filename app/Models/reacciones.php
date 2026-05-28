<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'reacciones';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'cod_rea',
        'tip_rea',
        'id_publicacion',
        'id_usuario',
    ];

    // Relaciones
    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'id_publicacion');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Scope para likes específicos
    public function scopeLikes($query)
    {
        return $query->where('tip_rea', 'like');
    }
}