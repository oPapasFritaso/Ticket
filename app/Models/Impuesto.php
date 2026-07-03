<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impuesto extends Model
{
    use HasFactory;

    protected $table = 'Impuesto';
    protected $primaryKey = 'id_impuesto';
    public $timestamps = false;

    protected $fillable = [
        'Nombre_impuesto', 'Tipo_impuesto', 'Porcentaje'
    ];
}
