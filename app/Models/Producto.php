<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'cod_pro',
        'nom_pro',
        'des_pro',
        'pre_pro',
        'cat_pro',
        'est_pro',
        'img_pro',
        'us_ven',
    ];

    protected $casts = [
        'pre_pro' => 'decimal:2',
    ];

    // Relaciones
    public function vendedor()
    {
        return $this->belongsTo(User::class, 'us_ven');
    }
}