<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'publicaciones';

    protected $fillable = [
        'con_pub',
        'us_id'
    ];

    public $timestamps = false;

    // 🔥 RELACIÓN CON USUARIO
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'us_id');
    }
}