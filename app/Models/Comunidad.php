<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
    use HasFactory;

    protected $table = 'comunidad'; // ojo: tu migración usa 'comunidad'
    protected $primaryKey = 'cod_com';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'nom_com',
        'des_com',
        'fot_com',
        'pri_com',
        'est_com',
        'usuario_id',
    ];

    // Usuario creador
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Miembros (pivot)
    public function miembros()
    {
        return $this->hasMany(MiembroComunidad::class, 'cod_com', 'cod_com');
    }

    // Publicaciones
    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'cod_com', 'cod_com');
    }
}
