<?php

namespace App\Http\Controllers;

use App\Models\AperturaCaja;
use App\Models\CuentaxCobrar;
use App\Models\DetalleAperturaCaja;
use App\Models\HistorialCXC;
use Illuminate\Http\Request;

class HistorialPagoscxcController extends Controller
{
    public function index()
    {
        $pagos = HistorialCXC::all();

        return view('facturas-credito.pagos.index', [
            'pagos' => $pagos
        ]);
    }

    public function create(CuentaxCobrar $cxc)
    {
        $aperturas = AperturaCaja::where('estado', 'ABIERTO')->get();
        
        return view('facturas-credito.pagos.create', [
            'cxc' => $cxc,
            'aperturas' => $aperturas
        ]);
    }

    public function store(Request $request)
    {
        $historial_cxc = new HistorialCXC();
        $cxc = CuentaxCobrar::find($request->cxc_id);

        // VALIDAR SI EL MONTO TOTAL ES MAYOR O IGUAL A MONTO ABONADO QUE SE PUEDA REALIZAR LA VENTA  
        if($request->saldo_pendiente >= $request->monto_abonado && $request->monto_abonado>0){
            // Actualizar la cuenta por cobrar
            $cxc->saldo_pendiente = $request->saldo_pendiente - $request->monto_abonado;
            // dd($cxc->saldo_pendiente);

            if($cxc->saldo_pendiente<=0){
                $cxc->estado = 'Cuenta pagada';
            }else{
                $cxc->estado = 'Cuenta abonada';
            }
            $cxc->save();

            // Almacenar el historial del pago
            $historial_cxc->cxc_id = $request->cxc_id;
            $historial_cxc->monto_abonado = $request->monto_abonado;
            $historial_cxc->save();

            // Afectar a caja
            $DetalleApertura = new DetalleAperturaCaja();
            $apertura = DetalleAperturaCaja::where('caja_id', $request->caja_id)->latest()->first();

            $DetalleApertura->descripcion = 'Pago para la factura: #'.$cxc->venta->documento;
            $DetalleApertura->apertura_cajas_id = $apertura->apertura_cajas_id;
            $DetalleApertura->ingreso = $request->monto_abonado;
            $DetalleApertura->saldo_total = ($apertura->saldo_total + $request->monto_abonado);
            $DetalleApertura->caja_id = $request->caja_id;
            $DetalleApertura->save();
            
            
        }else{
            return redirect()->route('facturas.credito.index')->with([
                'error' => 'Error',
                'mensaje' => 'El monto abonado excede al saldo pendiente, monto abonado: Q.'. $request->monto_abonado. ', saldo pendiente: Q.'.$request->saldo_pendiente,
                'tipo' => 'alert-danger'
            ]);
        }

        return redirect()->route('facturas.credito.index')->with([
            'error' => 'Exito',
            'mensaje' => 'El pago se realizo correctamente, saldo pendiente: Q.'.$cxc->saldo_pendiente,
            'tipo' => 'alert-success'
        ]);
    }
}
