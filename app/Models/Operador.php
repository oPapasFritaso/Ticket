<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operador extends Model
{
    use HasFactory;

    protected $table = 'Operador';
    protected $primaryKey = 'id_operador';
    protected $fillable = [
        'Nombre_op',
        'Direccion',
        'Telefono'
    ];
    public $timestamps = false;

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_operador', 'id_operador');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_operador', 'id_operador');
    }
}
