<?php

namespace App\Http\Controllers;

use App\Models\AperturaCaja;
use App\Models\DetalleAperturaCaja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetalleAperturaCajaController extends Controller
{
    public function index()
    {   
        // $detalleApertura = DetalleAperturaCaja::whereHas('Apertura', function ($query) {
        //     $query->where('estado', 'ABIERTO');
        // })->get();

        $detalleApertura = DetalleAperturaCaja::whereHas('Apertura', function ($query) {
            $query->where('estado', 'ABIERTO');
        })->where('caja_id', Auth::user()->caja_id)->get();
        
        
        return view('movimientos.index', compact('detalleApertura'));
    }

    public function create()
    {   
        // $detalleId = AperturaCaja::max('id');
        // if ($detalleId != null) $apertura = AperturaCaja::findOrFail($detalleId);

        $aperturaCaja = AperturaCaja::where('user_id', Auth::user()->id)->latest()->first();

        // if ($detalleId == null || $apertura->estado == 'CERRADO') {
        if ($aperturaCaja == null || $aperturaCaja->estado == 'CERRADO') {
            return redirect()->route('movimientos.index')->with([
                'error' => 'Error',
                'mensaje' => 'Se debe de aperturar una caja para el usuario: '.Auth::user()->name,
                'tipo' => 'alert-danger'
            ]);
        }else{
            $detalleApertura = DetalleAperturaCaja::all();
            return view('movimientos.create', compact('detalleApertura'));
        }
    }

    public function store(Request $request)
    {   
        if ($request->ingreso == null && $request->egreso == null) {
            return redirect()->route('movimientos.create')->with([
                'error' => 'Error',
                'mensaje' => 'Las entradas y salidas no pueden ser iguales',
                'tipo' => 'alert-danger'
            ]);
        } else {
            $DetalleApertura = new DetalleAperturaCaja();
            // $aperturaId = AperturaCaja::max('id');
            $aperturaCaja = AperturaCaja::where('user_id', Auth::user()->id)->latest()->first();
            $aperturaId = $aperturaCaja->id;

            // Buscar usuario para almacenar su caja correspondiente
            $user = User::find(Auth::user()->id);
            $caja_id = $user->caja_id;
            
            $DetalleApertura->descripcion = $request->descripcion;
            $DetalleApertura->ingreso = $request->ingreso;
            $DetalleApertura->egreso = $request->egreso;
            $DetalleApertura->apertura_cajas_id = $aperturaId;
            $DetalleApertura->caja_id = $caja_id;

            //Agregar saldo_total
            // $detalleId = DetalleAperturaCaja::max('id');
            // $id = DetalleAperturaCaja::findOrFail($detalleId);
            // Busqueda para descontar el saldo del usuario correspondiente
            $saldo = DetalleAperturaCaja::where('caja_id', $caja_id)->latest()->first();

            if($request->ingreso != null){
                $sum = $saldo->saldo_total + $request->ingreso;
                $DetalleApertura->saldo_total = $sum;
            }

            if($request->egreso != null){
                $sum = $saldo->saldo_total - $request->egreso;
                $DetalleApertura->saldo_total = $sum;
            }

            $DetalleApertura->save();

            return redirect()->route('movimientos.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Movimiento agregado correctamente',
                'tipo' => 'alert-success'
            ]);
        }
    }
}
