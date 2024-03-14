<?php

namespace App\Http\Controllers;

use App\Models\mediosdepago;
use Illuminate\Http\Request;

class mediosdepagoController extends Controller {

    public function index() {
        $medio = mediosdepago::all();
        return view('administracion.mediosdepago.index', compact('medio'));
    }

    public function create(){
        return view('administracion.mediosdepago.crear');
    }

    public function store(Request $request){
        $medio = new mediosdepago();

        $medio->medio_de_pago = ucfirst($request->medio_de_pago);

        try {

            $medio->save();
            return redirect()->route('configuracion.mediosdepago.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Medio de pago creado correctamente',
                'tipo' => 'alert-success'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('configuracion.mediosdepago.index')->with([
                'error' => 'Error',
                'mensaje' => 'El medio de pago no pudo ser creado',
                'tipo' => 'alert-danger'
            ]);
        }
    }

    public function show($id) {
        $medio = mediosdepago::find($id);
        return view('administracion.mediosdepago.editar', compact('medio'));
    }

    public function edit(mediosdepago $mediosdepago) {
        //
    }

    public function update(Request $request, mediosdepago $mediosdepago) {
        $mediosdepago = mediosdepago::find($request->id);
        $mediosdepago->medio_de_pago = ucfirst($request->medio_de_pago);

        try {
            $mediosdepago->save();
            return redirect()->route('configuracion.mediosdepago.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Medio de pago modificado correctamente',
                'tipo' => 'alert-primary'
            ]);
        } catch (\Exception $e) {
            $medio = $mediosdepago;
            return view('administracion.mediosdepago.editar', compact('medio'));
        }
    }

    public function destroy(mediosdepago $mediosdepago)
    {
        //
    }
}
