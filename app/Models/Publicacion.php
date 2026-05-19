<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    protected $table = 'publicaciones';

    protected $fillable = [
        'cod_pub',
        'con_pub',
        'img_pub',
        'us_id'
    ];

    public function reacciones()
    {
        return $this->hasMany(Like::class, 'id_publicacion');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'us_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_publicacion');
    }
}