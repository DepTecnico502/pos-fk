<?php

namespace App\Http\Controllers;

use App\Models\mediosdepago;
use App\Models\Pagos;
use App\Models\Recepciones;
use App\Models\tipo_documento;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagosController extends Controller
{
    public function index() {
        $pagos = Pagos::all();
        
        return view('pagos.index', compact('pagos'));
    }

    public function create(){
        $mediosdepago = mediosdepago::all();

        $idsBusqueda = [33, 34, 39, 41, 99, 100, 101];
        $tipodocumentos = tipo_documento::whereIn('id', $idsBusqueda)->get();

        $compras = Recepciones::where('condicion', '!=', 0)
        ->where('saldo_pendiente', '>', 0)
        ->get();

        return view('pagos.crear', compact(['mediosdepago', 'tipodocumentos', 'compras']));
    }

    public function store(Request $request){
        $pagos = new Pagos();

        $pagos->fecha = Carbon::now();
        $pagos->compra_id = $request->compra_id;
        $pagos->medio_pago_id = $request->medio_pago_id;
        $pagos->tipo_documentos_id = $request->tipo_documentos_id;
        $pagos->documento = $request->documento;
        $pagos->observaciones = $request->observaciones;
        $pagos->monto = $request->monto;

        if ($request->hasFile('url_imagen')) {
            $image = $request->file('url_imagen');
            $image_name = "/img_pagos/" . Str::random(65) . "." . $image->getClientOriginalExtension();
            $image->move(public_path('img_pagos'), $image_name);

            $pagos->url_imagen = $image_name;
        }

        $pagos->user_id = Auth::user()->id;

        //ACTUALIZAR SALDO PENDIENTE
        $compras = Recepciones::find($request->compra_id);
        $compras->saldo_pendiente = $request->saldo_pendiente - $request->monto;
 
        try {
            $pagos->save();
            $compras->save();

            return redirect()->route('pagos.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Pago creado correctamente',
                'tipo' => 'alert-success'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('pagos.create')->with([
                'error' => 'Error',
                'mensaje' => 'El pago no pudo ser creado' . $e->getMessage(),
                'tipo' => 'alert-danger'
            ]);
        }
    }

    public function view(){

    }
}
