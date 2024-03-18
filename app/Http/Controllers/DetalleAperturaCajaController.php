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
        $ultimos_saldos = DetalleAperturaCaja::select('detalle_apertura_cajas.caja_id', 'cajas.caja AS nombre_caja', 'detalle_apertura_cajas.descripcion', 'detalle_apertura_cajas.saldo_total', 'apertura_cajas.id AS apertura_caja')
        ->join(DB::raw('(SELECT caja_id, MAX(created_at) AS max_created_at
                        FROM detalle_apertura_cajas
                        GROUP BY caja_id) AS max_dates'), function($join) {
            $join->on('detalle_apertura_cajas.caja_id', '=', 'max_dates.caja_id');
            $join->on('detalle_apertura_cajas.created_at', '=', 'max_dates.max_created_at');
        })
        ->join('apertura_cajas', 'detalle_apertura_cajas.caja_id', '=', 'apertura_cajas.caja_id')
        ->join('cajas', 'detalle_apertura_cajas.caja_id', '=', 'cajas.id')
        ->where('apertura_cajas.estado', 'ABIERTO')
        ->get();

        return view('movimientos.index', [
            'ultimos_saldos' => $ultimos_saldos,
        ]);
    }

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

    public function show($id)
    {
        $detalleApertura = DetalleAperturaCaja::where('apertura_cajas_id', $id)->get();

        return view('movimientos.view', [
            'detalleApertura' => $detalleApertura
        ]);
    }
}
