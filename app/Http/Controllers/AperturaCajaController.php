<?php

namespace App\Http\Controllers;

use App\Models\AperturaCaja;
use App\Models\Caja;
use App\Models\DetalleAperturaCaja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AperturaCajaController extends Controller
{
    public function index()
    {
        $apertura = AperturaCaja::all();
        return view('apertura.index', compact('apertura'));
    }

    public function create()
    {   
        $cajas = Caja::all();

        return view('apertura.create', [
            'cajas' => $cajas
        ]);
    }

    public function store(Request $request)
    {
        $aperturaCaja = AperturaCaja::where('caja_id', $request->caja_id)->latest()->first();
        
        if ($aperturaCaja == null || $aperturaCaja->estado === 'CERRADO')
        {
            $apertura = new AperturaCaja();

            $apertura->saldo_inicial = $request->saldo_inicial;
            $apertura->fecha_apertura = $request->fecha_apertura;
            $apertura->user_id = Auth::user()->id;
            $apertura->caja_id = $request->caja_id;
            $apertura->save();

            $DetalleApertura = new DetalleAperturaCaja();
            $DetalleApertura->descripcion = 'Saldo inicial';
            $DetalleApertura->apertura_cajas_id = $apertura->id;
            $DetalleApertura->saldo_total = $request->saldo_inicial;
            $DetalleApertura->caja_id = $request->caja_id;
            $DetalleApertura->save();

            return redirect()->route('apertura.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Apertura creada correctamente',
                'tipo' => 'alert-success'
            ]);
        }else
        {
            return redirect()->route('apertura.create')->with([
                'error' => 'ERROR',
                'mensaje' => 'Ya existe una apertura de caja: ' . $aperturaCaja->caja->caja,
                'tipo' => 'alert-danger'
            ]);
        }
    }

    public function show($id)
    {
        $detalleApertura = DetalleAperturaCaja::whereHas('Apertura', function ($query) use ($id){
            $query->where('apertura_cajas_id', '=', $id);
        })->get();
        
        return view('apertura.view', compact('detalleApertura'));
    }

    public function edit($id)
    {
        $apertura = AperturaCaja::find($id);
        return view('apertura.edit', compact('apertura'));
    }

    public function update(Request $request, $id)
    {   
        // Buscar el registro que se desea actualizar por su ID
        $AperturaCaja = AperturaCaja::find($id);

        //Monedas
        $cinco_moneda = $request->cinco_moneda * 0.05;
        $diez_moneda = $request->diez_moneda * 0.10;
        $veinticinco_moneda = $request->veinticinco_moneda * 0.25;
        $cincuenta_moneda = $request->cincuenta_moneda * 0.50;
        $quetzal_moneda = $request->quetzal_moneda * 1;

        //Billetes
        $quetzal_billete = $request->quetzal_billete * 1;
        $cinco_billete = $request->cinco_billete * 5;
        $diez_billete = $request->diez_billete * 10;
        $veinte_billete = $request->veinte_billete * 20;
        $cincuenta_billete = $request->cincuenta_billete * 50;
        $cien_billete = $request->cien_billete * 100;
        $doscinetos_billete = $request->doscinetos_billete * 200;

        $total_arqueo = ($cinco_moneda + $diez_moneda + $veinticinco_moneda + $cincuenta_moneda + $quetzal_moneda) 
            + ($quetzal_billete + $cinco_billete + $diez_billete + $veinte_billete + $cincuenta_billete + $cien_billete + $doscinetos_billete);

        $caja_id = $AperturaCaja->caja_id;

        // Busqueda para descontar el saldo del usuario correspondiente
        $id = DetalleAperturaCaja::where('caja_id', $caja_id)->latest()->first();
        $saldo = $total_arqueo - $id->saldo_total;

        //Guardar datos
        if ( $saldo >= 0) {
            $AperturaCaja->saldo_sobrante = $saldo;
        }else if( $saldo < 0 ){
            $AperturaCaja->saldo_faltante = $saldo;
        }

        $AperturaCaja->saldo_inicial = $request->saldo_inicial;
        $AperturaCaja->saldo_total = $id->saldo_total;
        $AperturaCaja->arqueo_caja = $total_arqueo;
        $AperturaCaja->user_id = Auth::user()->id;
        $AperturaCaja->caja_id = $caja_id;
        $AperturaCaja->estado = 'CERRADO';
        $AperturaCaja->fecha_apertura = $request->fecha_apertura;


        $AperturaCaja->save();

        return redirect()->route('apertura.index')->with([
            'error' => 'Exito',
            'mensaje' => 'Arqueo realizado correctamente',
            'tipo' => 'alert-success'
        ]);
    }
}
