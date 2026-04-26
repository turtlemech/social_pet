<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'reacciones'; // 👈 tu tabla real

    protected $fillable = [
        'id_usuario',
        'id_publicacion',
        'tipo'
    ];
}