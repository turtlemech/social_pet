<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
    
class Amistad extends Model
{
    use HasFactory;

    protected $table = 'amistades';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'cod_ami',
        'est_ami',
        'us_sol',
        'us_rec',
    ];

    // Relaciones
    public function solicitante()
    {
        return $this->belongsTo(User::class, 'us_sol');
    }

    public function receptor()
    {
        return $this->belongsTo(User::class, 'us_rec');
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('est_ami', 'pendiente');
    }

    public function scopeAceptadas($query)
    {
        return $query->where('est_ami', 'aceptada');
    }
}