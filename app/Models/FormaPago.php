<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    protected $table = 'formapago';
    protected $primaryKey = 'id_formapago';
    public $timestamps = false;

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }


}