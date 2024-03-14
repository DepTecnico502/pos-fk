<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.crear');
    }

    public function store(Request $request)
    {
        $cliente = new Cliente;
        $cliente->rut = $request->rut;
        $cliente->nombre = $request->nombre;
        $cliente->direccion = $request->direccion;
        $cliente->mail = $request->email;
        $cliente->telefono = $request->telefono;
        $cliente->save();
        return redirect()->route('clientes.index')->with([
            'error' => 'Exito',
            'mensaje' => 'Cliente creado correctamente',
            'tipo' => 'alert-primary'
        ]);
    }

    public function show($cliente)
    {
        $cliente = Cliente::find($cliente);
        return view('clientes.editar', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $cliente->nombre = $request->nombre;
        $cliente->direccion = $request->direccion;
        $cliente->mail = $request->email;
        $cliente->telefono = $request->telefono;

        $cliente->save();
        return redirect()->route('clientes.index')->with([
            'error' => 'Exito',
            'mensaje' => 'Cliente modificado correctamente',
            'tipo' => 'alert-primary'
        ]);
    }
}
