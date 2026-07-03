<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    use HasFactory;

    protected $table = 'Promocion';
    protected $primaryKey = 'id_promocion';
    public $timestamps = false;

    protected $fillable = [
        'Fecha_ini', 'Fecha_fin', 'Precio'
    ];
}
