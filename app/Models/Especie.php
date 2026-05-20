<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especie extends Model
{
    use HasFactory;

    protected $table = 'especies';
    
    protected $fillable = [
        'nom_esp',
        'raz_mas',
        'tam_mas',
    ];

    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'especie_id');
    }
}