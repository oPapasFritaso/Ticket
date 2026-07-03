<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTicket extends Model
{
    use HasFactory;
    protected $table = 'DetalleTicket'; 
    protected $primaryKey = 'id_detalle_ticket';
    public $timestamps = false;
    

    protected $fillable = [
        'id_ticket',
        'id_producto',
        'Cantidad',
        'Precio_unitario'
    ];

    public function producto() 
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function ticket() 
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }
}
