<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Operador;
use App\Models\Tienda;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Devolucion;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VentaController extends Controller
{
    public function index()
    {
        $productos = session()->get('venta', []);
        $total = array_sum(array_column($productos, 'Precio'));
        $operador = session('operador_activo') 
            ? Operador::find(session('operador_activo'))
            : Operador::first();
        $productosDB = Producto::all();

        return view('venta.index', compact('productos', 'total', 'productosDB', 'operador'));
    }

    public function cambiarOperador(Request $request)
    {
        $request->validate(['id_operador' => 'required|exists:operadores,id_operador']);
        session(['operador_activo' => $request->id_operador]);
        return redirect()->route('venta.index')->with('success', 'Operador cambiado correctamente');
    }

    public function agregarProducto(Request $request)
    {
        $codigo = $request->input('codigo');
        $producto = Producto::where('Codigo_barra', $codigo)->first();

        if ($producto) {
            $venta = session()->get('venta', []);
            $venta[] = [
                'Codigo' => $producto->Codigo_barra,
                'Descripcion' => $producto->Nombre_pr,
                'Precio' => $producto->Precio,
            ];
            session()->put('venta', $venta);
        }

        return redirect()->route('venta.index');
    }

    public function eliminarProducto(Request $request)
    {
        $codigo = $request->input('codigo');
        $venta = session()->get('venta', []);

        $venta = array_filter($venta, function ($p) use ($codigo) {
        return $p['Codigo'] !== $codigo;});

        session()->put('venta', array_values($venta));
        return redirect()->route('venta.index')->with('success', 'Producto eliminado');
    }

    public function cobrar()
    {
        $productos = session()->get('venta', []);
        if (empty($productos)) {
            return redirect()->route('venta.index')->with('error', 'No hay productos en la venta');
        }

        $total = array_sum(array_column($productos, 'Precio'));
        $operador = session('operador_activo')
            ? Operador::find(session('operador_activo'))
            : Operador::first();
        $tienda = \App\Models\Tienda::first();

        DB::beginTransaction();
        try {
            $venta = \App\Models\Venta::create([
                'id_tienda' => $tienda->id_tienda ?? null,
                'id_operador' => $operador->id_operador ?? null,
                'id_impuesto' => null,
                'no_registro' => uniqid('V-'),
            ]);
            foreach ($productos as $p) {
                $productoDB = \App\Models\Producto::where('Codigo_barra', $p['Codigo'])->first();

                if ($productoDB) {
                    \App\Models\DetalleVenta::create([
                        'id_venta' => $venta->id_venta,
                        'id_producto' => $productoDB->id_producto,
                        'Cantidad' => 1,
                        'Precio_unitario' => $productoDB->Precio,
                    ]);
                }
            }
            $ticket = \App\Models\Ticket::create([
                'id_venta' => $venta->id_venta,
                'id_operador' => $operador->id_operador ?? null,
                'id_cliente' => null,
                'Fecha' => now()->toDateString(),
                'Hora' => now()->toTimeString(),
                'Total' => $total,
                'no_registro' => uniqid('T-'),
            ]);
            DB::commit();
            session()->forget('venta');

            return redirect()->route('venta.index')->with('success', 'Venta y Ticket registrados correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('venta.index')->with('error', 'Error al guardar venta: ' . $e->getMessage());
        }
    }

    public function generarTicket(Request $request)
    {
        $productos = session()->get('venta', []);
        $total = array_sum(array_column($productos, 'Precio'));
        $operador = session('operador_activo')
            ? Operador::find(session('operador_activo'))
            : Operador::first();
        $tienda = Tienda::first();

        $montoPagado = $request->input('monto', 0);
        $cambio = max(0, $montoPagado - $total);
        $pdf = Pdf::loadView('venta.ticket', [
            'productos' => $productos,
            'total' => $total,
            'operador' => $operador,
            'tienda' => $tienda,
            'pago' => ['Monto' => $montoPagado],
            'ticket' => ['Total' => $total],
            'cambio' => $cambio
        ])->setPaper([0, 0, 226.77, 600], 'portrait');

        session()->forget('venta');
        return $pdf->stream('ticket.pdf');
    }

    public function ventasDelDia(Request $request)
    {
        $fechaHoy = now()->format('Y-m-d');
        $ventas = Venta::with('operador', 'detalles', 'ticket.cliente')
            ->whereDate('fecha', $fechaHoy)
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json($ventas);
    }

    public function show($id)
    {
        $venta = Venta::with(['detalles', 'operador'])->findOrFail($id);
        return view('venta.detalle', compact('venta'));
    }
}
