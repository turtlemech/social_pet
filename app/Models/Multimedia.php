<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multimedia extends Model
{
    use HasFactory;

    protected $table = 'multimedia';

    protected $fillable = [
        'nom_mul',
        'art_mul',
        'gen_mul',
        'dur_mul',
        'url_mul',
        'tip_mul',
    ];
}