<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    public function index()
    {
        $almacenes = Almacen::with(['tienda', 'producto', 'promocion'])->get();
        return view('almacenes.index', compact('almacenes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tienda' => 'required|exists:tiendas,id_tienda',
            'id_producto' => 'required|exists:productos,id_producto',
            'Cantidad_pr' => 'required|integer|min:0',
        ]);

        Almacen::create($request->all());
        return redirect()->back()->with('success', 'Registro agregado al almacén correctamente');
    }
}
