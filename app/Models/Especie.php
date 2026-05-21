<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especie extends Model
{
    use HasFactory;

    protected $table = 'especies';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'nom_esp',
        'raz_mas',
        'tam_mas',
    ];

    // Relación con mascotas
    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'especie_id');
    }

    // Accessor para obtener el nombre de la especie
    public function getNombreAttribute()
    {
        return $this->nom_esp;
    }
}




