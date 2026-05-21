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

    protected $casts = [
        'est_mas' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con especie
    public function especie()
    {
        return $this->belongsTo(Especie::class, 'especie_id');
    }

    // Relación con usuario (dueño)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Alias para compatibilidad
    public function user()
    {
        return $this->usuario();
    }

    // Relación con adopciones
    public function adopciones()
    {
        return $this->hasMany(Adopcion::class, 'mas_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('est_mas', 'activo');
    }

    public function scopePorEspecie($query, $especieNombre)
    {
        return $query->whereHas('especie', function($q) use ($especieNombre) {
            $q->where('nom_esp', $especieNombre);
        });
    }

    // Accessor para obtener la URL de la foto
    public function getFotoUrlAttribute()
    {
        if ($this->fot_mas) {
            return asset('storage/' . $this->fot_mas);
        }
        return null;
    }
}



