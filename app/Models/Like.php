<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'reacciones';

    protected $fillable = [
        'id_usuario',
        'id_publicacion',
        'tipo'
    ];
}