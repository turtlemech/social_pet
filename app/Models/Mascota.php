<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;

    protected $table = 'mascotas';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'nom_mas',
        'sex_mas',
        'des_mas',
        'fot_mas',
        'est_mas',
        'especie_id',
        'usuario_id',
    ];

    // Relaciones
    public function especie()
    {
        return $this->belongsTo(Especie::class, 'especie_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function adopciones()
    {
        return $this->hasMany(Adopcion::class, 'mas_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('est_mas', 'activo');
    }
}