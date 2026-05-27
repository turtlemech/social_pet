<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $table = 'notificaciones';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'cod_not',
        'tit_not',
        'men_not',
        'tip_not',
        'lei_not',
        'fch_lei_not',
        'usuario_id',
        'url_not',
    ];

    protected $casts = [
        'lei_not' => 'boolean',
        'fch_lei_not' => 'datetime',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Scopes
    public function scopeNoLeidas($query)
    {
        return $query->where('lei_not', false);
    }

    // Métodos
    public function marcarComoLeida()
    {
        $this->lei_not = true;
        $this->fch_lei_not = now();
        return $this->save();
    }
}