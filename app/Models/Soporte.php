<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soporte extends Model
{
    use HasFactory;

    protected $table = 'soporte';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'cod_sop',
        'cod_us',
        'asu_sop',
        'cat_sop',
        'pri_sop',
        'men_sop',
        'est_sop',
        'res_sop',
        'cod_admin',
        'fec_resuelto',
    ];

    protected $casts = [
        'fec_resuelto' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'cod_us', 'cod_us');
    }

    public function administrador()
    {
        return $this->belongsTo(User::class, 'cod_admin', 'cod_us');
    }
}