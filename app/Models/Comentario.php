<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentarios';

    protected $primaryKey = 'id';

    protected $fillable = [
        'comentario',
        'id_publicacion',
        'id_usuario'
    ];

    public $timestamps = true;

    // publicación
    public function publicacion()
    {
        return $this->belongsTo(Post::class, 'id_publicacion', 'id');
    }

    // usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
}