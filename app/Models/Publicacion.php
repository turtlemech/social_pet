<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    protected $table = 'publicaciones';

    protected $primaryKey = 'id_publicacion';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'id_usuario',
        'contenido',
        'imagen'
    ];

    public function reacciones()
    {
        return $this->hasMany(Like::class, 'id_publicacion');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    public function comentarios()
{
    return $this->hasMany(Comentario::class, 'id_publicacion');
}
}