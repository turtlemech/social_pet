<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
    use HasFactory;

    protected $table = 'comunidad';
    protected $primaryKey = 'cod_com';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nom_com',
        'des_com',
        'fot_com',
        'pri_com',
        'cat_com',
        'est_com',
        'fch_cre_com',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id');
    }
}