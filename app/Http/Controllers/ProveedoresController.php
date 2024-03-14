<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.crear');
    }

    public function store(Request $request)
    {
        $proveedor = new Proveedor();
        $proveedor->rut = $request->rut;
        $proveedor->nombre = $request->nombre;
        $proveedor->direccion = $request->direccion;
        $proveedor->mail = $request->email;
        $proveedor->telefono = $request->telefono;

        $proveedor->save();
        return redirect()->route('proveedores.index')->with([
            'error' => 'Exito',
            'mensaje' => 'Proveedor creado correctamente',
            'tipo' => 'alert-success'
        ]);
    }

    public function show($proveedor)
    {
        $proveedor = Proveedor::find($proveedor);
        return view('proveedores.editar', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $proveedor->nombre = $request->nombre;
        $proveedor->direccion = $request->direccion;
        $proveedor->mail = $request->email;
        $proveedor->telefono = $request->telefono;

        $proveedor->save();
        return redirect()->route('proveedores.index')->with([
            'error' => 'Exito',
            'mensaje' => 'Proveedor modificado correctamente',
            'tipo' => 'alert-primary'
        ]);
    }
}
