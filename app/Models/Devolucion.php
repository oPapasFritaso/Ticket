<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use HasFactory;

    protected $table = 'Devolucion';
    protected $primaryKey = 'id_devolucion';
    public $timestamps = false;

    protected $fillable = [
        'Cantidad_prod', 'Precio_prod', 'Fecha_devol', 'Cambio', 'id_venta'
    ];
}
