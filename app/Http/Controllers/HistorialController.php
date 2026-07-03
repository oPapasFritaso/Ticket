<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Cliente;
use App\Models\Operador;
use Carbon\Carbon;

class HistorialController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['operador', 'cliente', 'venta.detalles.producto'])
            ->orderBy('Fecha', 'desc')
            ->get();
        return view('historial.index', compact('tickets')); 
    }
    public function ventasDelDia()
    {
        $hoy = now()->toDateString(); 

        $tickets = Ticket::with(['operador', 'cliente', 'venta.detalles.producto'])
            ->whereDate('Fecha', $hoy)
            ->orderBy('Hora', 'desc')
            ->get();

        return response()->json($tickets);
    }

    public function show($id)
    {
        $ticket = Ticket::with(['operador', 'cliente', 'venta.detalles.producto'])
            ->findOrFail($id);

        return response()->json([
            'ticket' => $ticket,
        
            'detalles' => $ticket->venta ? $ticket->venta->detalles : []
        ]);
    }
}
