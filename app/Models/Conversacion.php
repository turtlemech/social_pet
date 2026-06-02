<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Conversacion extends Model
{
    use HasFactory;

    protected $table = 'conversaciones';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'cod_con',
        'tip_con',
        'nom_con',
        'us_crea',
        'fch_act_con',
        'act_con',
    ];

    protected $casts = [
        'fch_act_con' => 'datetime',
        'act_con' => 'boolean',
    ];

    // ================= RELACIONES =================

    public function creador()
    {
        return $this->belongsTo(
            User::class,
            'us_crea'
        );
    }

    public function participantes()
    {
        return $this->belongsToMany(
            User::class,
            'conversacion_usuario',
            'con_id',
            'us_id'
        )->withTimestamps();
    }

    public function mensajes()
    {
        return $this->hasMany(
            Mensaje::class,
            'con_id'
        );
    }

    public function ultimoMensaje()
    {
        return $this->hasOne(
            Mensaje::class,
            'con_id'
        )->latest();
    }
}