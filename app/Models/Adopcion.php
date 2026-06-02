<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adopcion extends Model
{
    use HasFactory;

    protected $table = 'adopciones';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'des_ado',
        'fch_pub_ado',
        'fch_sol_ado',
        'fch_res_ado',
        'est_ado',
        'mas_id',
        'us_act',
        'us_sol',
    ];

    protected $casts = [
        'fch_pub_ado' => 'datetime',
        'fch_sol_ado' => 'datetime',
        'fch_res_ado' => 'datetime',
    ];

    // Relaciones
    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'mas_id');
    }

    public function usuarioActivo()
    {
        return $this->belongsTo(User::class, 'us_act');
    }

    public function solicitante()
    {
        return $this->belongsTo(User::class, 'us_sol');
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('est_ado', 'pendiente');
    }

    public function scopeAprobadas($query)
    {
        return $query->where('est_ado', 'aprobada');
    }
}