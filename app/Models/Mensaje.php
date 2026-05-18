<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mascota extends Model
{
    use HasFactory;
    
    protected $table = 'mascotas';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'cod_mas',
        'nom_mas',
        'esp_mas',
        'raz_mas',
        'ed_mas',
        'pes_mas',
        'fot_mas',
        'us_id',
        'descripcion',
    ];
    
    /**
     * Relación con el usuario (dueño)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'us_id');
    }
}