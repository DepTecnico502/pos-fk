<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function index()
    {
        $cajas = Caja::all();

        return view('cajas.index', [
            'cajas' => $cajas
        ]);
    }

    public function edit($id)
    {
        $caja = Caja::find($id);

        return view('cajas.editar', [
            'caja' => $caja
        ]);
    }

    public function update(Request $request, $id)
    {
        $caja = Caja::find($id);

        $request->validate([
            'caja' => 'required',
        ]);

        try {
            $caja->caja = $request->caja;
            $caja->save();
            return redirect()->route('cajas.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Caja modificado correctamente',
                'tipo' => 'alert-primary'
            ]);
        } catch (\Exception $e) {
            $id = $caja->id;

            return view('administracion.mediosdepago.editar', [
                'id' => $id
            ]);
        }
    }

    public function create()
    {
        return view('cajas.crear');
    }

    public function store(Request $request)
    {
        try {
            $caja = new Caja();
            $caja->caja = $request->caja;
            $caja->save();

            return redirect()->route('cajas.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Caja creada correctamente',
                'tipo' => 'alert-success'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('caja.index')->with([
                'error' => 'Error',
                'mensaje' => 'La caja no pudo ser creada',
                'tipo' => 'alert-danger'
            ]);
        }
    }
}
