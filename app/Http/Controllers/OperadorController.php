<?php

namespace App\Http\Controllers;

use App\Models\Operador;
use Illuminate\Http\Request;

class OperadorController extends Controller
{
    public function index()
    {
        $operadores = Operador::all();
        return view('operadores.index', compact('operadores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:operadores',
            'contrasena' => 'required|string|min:6',
        ]);

        Operador::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contrasena' => bcrypt($request->contrasena),
        ]);

        return redirect()->back()->with('success', 'Operador agregado correctamente');
    }
}
