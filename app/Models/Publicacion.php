<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'cod_pub',
        'com_pub',
        'img_pub',
        'us_id',
        'est_pub',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'us_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_publicacion');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'id_publicacion');
    }
}