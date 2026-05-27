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
        'mascota_id',
        'est_pub',
    ];

    // ================= USUARIO =================

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'us_id'
        );
    }

    // ================= MASCOTA =================

    public function mascota()
    {
        return $this->belongsTo(
            Mascota::class,
            'mascota_id'
        );
    }

    // ================= COMENTARIOS =================

   public function comentarios()

{

    return $this->hasMany(

        Comentario::class,

        'id_publicacion'

    )->where('estado', 'activo');

}

    // ================= LIKES =================

    public function likes()
    {
        return $this->hasMany(
            Like::class,
            'id_publicacion'
        )->where('tip_rea', 'like');
    }
}