<?php

namespace App\Http\Controllers;

use App\Models\AperturaCaja;
use App\Models\Caja;
use App\Models\DetalleAperturaCaja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetalleAperturaCajaController extends Controller
{
    public function index()
    {
        // Consulta para solo mostrar las cajas aperturadas
        $aperturas = AperturaCaja::where('estado', 'ABIERTO')->get();

        // Obtener solo los IDs de las cajas aperturadas
        $cajasAperturadasIds = $aperturas->pluck('id');

        // Consulta para obtener los detalles de apertura de cajas para las cajas aperturadas
        $detalleApertura = DetalleAperturaCaja::whereIn('apertura_cajas_id', $cajasAperturadasIds)
        ->whereIn('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                ->from('detalle_apertura_cajas')
                ->groupBy('apertura_cajas_id');
        })
        ->get();

        // dd($detalleApertura);
        return view('movimientos.index', [
            'detalleApertura' => $detalleApertura,
        ]);
    }

    // $detalleApertura = DetalleAperturaCaja::whereHas('Apertura', function ($query) {
    //     $query->where('estado', 'ABIERTO');
    // })->get();
    public function create()
    {   
        // Consulta para solo mostrar las cajas aperturadas
        $aperturas = AperturaCaja::where('estado', 'ABIERTO')->get();

        return view('movimientos.create', [
            'aperturas' => $aperturas
        ]);
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
            $aperturaCaja = AperturaCaja::where('caja_id', $request->caja_id)->latest()->first();
            $aperturaId = $aperturaCaja->id;
            
            $DetalleApertura->descripcion = $request->descripcion;
            $DetalleApertura->ingreso = $request->ingreso;
            $DetalleApertura->egreso = $request->egreso;
            $DetalleApertura->apertura_cajas_id = $aperturaId;
            $DetalleApertura->caja_id = $request->caja_id;

            $saldo = DetalleAperturaCaja::where('caja_id', $request->caja_id)->latest()->first();

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
