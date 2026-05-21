<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaccion extends Model
{
    protected $table = 'reacciones';
    
    protected $fillable = [
        'id_publicacion',
        'id_usuario',
        'tipo'
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
}