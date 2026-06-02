<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'publicaciones';

    protected $primaryKey = 'id';

    protected $fillable = [
        'us_id',
        'con_pub',
        'img_pub'
    ];

    public $timestamps = true;

    // usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'us_id', 'id');
    }

    // comentarios
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_publicacion', 'id');
    }

    // likes
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_publicacion', 'id');
    }
}