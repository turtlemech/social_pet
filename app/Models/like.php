<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'reacciones';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_usuario',
        'id_publicacion',
        'tip_rea'
    ];

    public $timestamps = true;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'id_publicacion');
    }
}