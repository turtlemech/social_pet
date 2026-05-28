<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Publicacion;
use App\Models\User;

class Comentario extends Model
{
    protected $table = 'comentarios';

    protected $primaryKey = 'id';

    protected $fillable = [
        'con_com',
        'id_publicacion',
        'id_usuario',
        'estado'
    ];

    public $timestamps = true;

    // publicación
    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'id_publicacion', 'id');
    }

    // usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
}