<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    use HasFactory;

    protected $table = 'Tienda';
    protected $primaryKey = 'id_tienda';
    public $timestamps = false;

    protected $fillable = [
        'Nombre', 'Direccion', 'Telefono1', 'Telefono2', 'P_Web1', 'P_Web2', 'P_Web3'
    ];
}
