<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Especie;
use App\Models\User;
use App\Models\Adopcion;
use App\Models\Publicacion;

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

    // ================= ESPECIE =================

    public function especie()
    {
        return $this->belongsTo(
            Especie::class,
            'especie_id'
        );
    }

    // ================= USUARIO =================

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'usuario_id'
        );
    }

    // Alias para compatibilidad
    public function user()
    {
        return $this->usuario();
    }

    // ================= PUBLICACIONES =================

    public function publicaciones()
    {
        return $this->hasMany(
            Publicacion::class,
            'mascota_id'
        );
    }

    // ================= ADOPCIONES =================

    public function adopciones()
    {
        return $this->hasMany(
            Adopcion::class,
            'mas_id'
        );
    }

    // ================= SCOPES =================

    public function scopeActivos($query)
    {
        return $query->where(
            'est_mas',
            'activo'
        );
    }

    public function scopePorEspecie(
        $query,
        $especieNombre
    ) {
        return $query->whereHas(
            'especie',
            function ($q) use ($especieNombre) {

                $q->where(
                    'nom_esp',
                    $especieNombre
                );
            }
        );
    }

    // ================= ACCESSOR FOTO =================

    public function getFotoUrlAttribute()
    {
        if ($this->fot_mas) {

            return asset(
                'storage/' . $this->fot_mas
            );
        }

        return null;
    }
    
    public function eventos()
{
    return $this->belongsToMany(
        Evento::class,
        'mascotas_evento',
        'mascota_id',
        'evento_id'
    )->withTimestamps();
}
 // ================= SEGUIDORES =================

public function seguidores()
{
    return $this->belongsToMany(

        User::class,

        'seguimiento_mascota',

        'mas_seg',

        'us_seg'

    )->withTimestamps();
}
}