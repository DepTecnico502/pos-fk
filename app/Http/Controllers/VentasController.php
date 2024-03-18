<?php

namespace App\Http\Controllers;

use App\Models\AperturaCaja;
use App\Models\Ventas;
use App\Models\DetalleVentas;
use App\Models\Articulo;
use App\Models\tipo_documento;
use App\Models\mediosdepago;
use App\Models\Cliente;
use App\Models\CuentaxCobrar;
use App\Models\DetalleAperturaCaja;
use App\Models\DetalleMovimientosArticulos;
use App\Models\HistorialCXC;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VentasController extends Controller
{
    public function index()
    {
        if (session('venta')) {
            session()->forget('venta');
        }

        $fechaHoy = Carbon::now();

        $ventas = Ventas::all();
        $venta_total = Ventas::whereDate('created_at', $fechaHoy)
            ->where('estado', '=', 1)
            ->sum('monto_total');

        $monto_venta_total = Ventas::where('estado', '=', 1)
            ->sum('monto_total');
        return view('ventas.index', compact(['ventas', 'venta_total', 'monto_venta_total']));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $aperturas = AperturaCaja::where('estado', 'ABIERTO')->get();

        $idsBusqueda = [33, 41, 99];
        $tipo_documento = tipo_documento::whereIn('id', $idsBusqueda)->get();
        $articulos = Articulo::all()->where('stock', '>', 0)->where('estado', '=', 1);
        $medios_pago = mediosdepago::all();
        return view('ventas.create', compact(['clientes', 'articulos', 'tipo_documento', 'medios_pago','aperturas']));
    }

    public function addArticulo(Request $request)
    {
        $venta_new = [];
        $venta_flag = false;
        if (session('venta')) {
            $venta = session('venta');

            foreach (session('venta') as $value) {
                if ($value['articulo_id'] == $request->articulo) {
                    $venta_tmp = new DetalleVentas();

                    //$venta_tmp = nombre de las columnas de la BD
                    $venta_tmp->articulo = Articulo::find($request->articulo);
                    $venta_tmp->articulo_id = $request->articulo;
                    $venta_tmp->cantidad = $request->unidades;
                    $venta_tmp->descuento = $request->descuento;
                    $venta_tmp->observacion = $request->observacion;
                    $venta_tmp->precio_venta = $request->precio_venta;
                    $venta_tmp->preci_compra = $request->precio_compra;
                    $venta_tmp->total = $request->precio_venta * $request->unidades;
                    array_push($venta_new, $venta_tmp);
                    $venta_flag = true;
                } else {
                    $venta_tmp = new DetalleVentas();

                    $venta_tmp->articulo = Articulo::find($value->articulo_id);
                    $venta_tmp->articulo_id = $value->articulo_id;
                    $venta_tmp->cantidad = $value['cantidad'];
                    $venta_tmp->descuento = $value['descuento'];
                    $venta_tmp->observacion = $value['observacion'];
                    $venta_tmp->precio_venta = $value['precio_venta'];
                    $venta_tmp->precio_compra = $value['precio_compra'];
                    $venta_tmp->total = $value['total'];
                    array_push($venta_new, $venta_tmp);
                }
            }
            if ($venta_flag == false) {
                $venta_tmp = new DetalleVentas();

                $venta_tmp->articulo = Articulo::find($request->articulo);
                $venta_tmp->articulo_id = $request->articulo;
                $venta_tmp->cantidad = $request->unidades;
                $venta_tmp->descuento = $request->descuento;
                $venta_tmp->observacion = $request->observacion;
                $venta_tmp->precio_venta = $request->precio_venta;
                $venta_tmp->precio_compra = $request->precio_compra;
                $venta_tmp->total = $request->precio_venta * $request->unidades;
                array_push($venta_new, $venta_tmp);
            }
            session(['venta' => $venta_new]);
        } else {
            $venta = new DetalleVentas();
            $venta->articulo = Articulo::find($request->articulo);
            $venta->articulo_id = $request->articulo;
            $venta->cantidad = $request->unidades;
            $venta->descuento = $request->descuento;
            $venta->observacion = $request->observacion;
            $venta->precio_venta = $request->precio_venta;
            $venta->precio_compra = $request->precio_compra;
            $venta->total = $request->precio_venta * $request->unidades;
            array_push($venta_new, $venta);
            session(['venta' => $venta_new]);
        }

        $clientes = Cliente::all();
        $aperturas = AperturaCaja::where('estado', 'ABIERTO')->get();

        $articulos = Articulo::all()->where('stock', '>', 0)->where('estado', '=', 1);
        $idsBusqueda = [33, 41, 99];
        $tipo_documento = tipo_documento::whereIn('id', $idsBusqueda)->get();
        $medios_pago = mediosdepago::all();

        return view('ventas.create', compact(['clientes', 'articulos', 'tipo_documento', 'medios_pago', 'aperturas']));
    }

    public function store(Request $request)
    {
        $venta = Ventas::firstWhere([['documento', '=', $request->numero_documento], ['tipo_documentos_id', '=', $request->tipo_documento]]);
        
        if ($venta) {
            return redirect()->route('ventas.create')->with([
                'error' => 'Error',
                'mensaje' => 'el numero de documento ya existe',
                'tipo' => 'alert-danger'
            ]);
        } else {
            $venta = new Ventas();

            $venta->unidades = $request->total_articulos;
            $venta->monto_total = $request->monto_total;
            $venta->tipo_documentos_id = $request->tipo_documento;
            $venta->documento = $request->numero_documento;
            $venta->cliente_id = $request->cliente;
            $venta->medio_pago_id = $request->medio_de_pago;
            $venta->condicion = $request->condicion;
            $venta->fecha_entrega = $request->fecha_entrega;
            $venta->user_id = Auth::user()->id;
            $venta->save();

            $cuenta_x_cobrar = new CuentaxCobrar();

            if($request->condicion == 1){
                $cuenta_x_cobrar->venta_id =$venta->id;
                $cuenta_x_cobrar->cliente_id =$request->cliente;
                $cuenta_x_cobrar->dias_credito =$request->dias_credito;
                $cuenta_x_cobrar->fecha_pagar =$request->fecha_a_pagar;
                $cuenta_x_cobrar->monto_total =$request->monto_total;
                // Calcular el saldo pendiente cuando el cliente deja un anticipo
                if($request->anticipo){
                    $cuenta_x_cobrar->saldo_pendiente = $request->monto_total - $request->anticipo;
                }else{
                    $cuenta_x_cobrar->saldo_pendiente = $request->monto_total;
                }
                $cuenta_x_cobrar->estado = 'Cuenta abonada';
                $cuenta_x_cobrar->save();

                if($request->anticipo){
                    $historial_cxc = new HistorialCXC();
                    $historial_cxc->cxc_id = $cuenta_x_cobrar->id;
                    $historial_cxc->monto_abonado = $request->anticipo;
                    $historial_cxc->save();

                    // REGISTRAR MOVIMIENTO CUANDO SE DEJA UN ANTICIPO
                    // $ventaId = Ventas::max('id');
                    $DetalleApertura = new DetalleAperturaCaja();
                    $apertura = DetalleAperturaCaja::where('caja_id', $request->caja_id)->latest()->first();
        
                    $DetalleApertura->descripcion = 'Anticipo para la factura: #'.$request->numero_documento;
                    $DetalleApertura->apertura_cajas_id = $apertura->apertura_cajas_id;
                    $DetalleApertura->ingreso = $request->anticipo;
                    // Validar cuando se deja un anticipo para guardar el movimiento como "Anticipo"
                    $DetalleApertura->saldo_total = ($apertura->saldo_total + $request->anticipo);
                    $DetalleApertura->caja_id = $request->caja_id;
                    $DetalleApertura->save();
                }
            }
        }

        $venta_id = $venta->id;
        $venta_detalle = session('venta');

        foreach ($venta_detalle as $value) {
            $detalle = new DetalleVentas();

            $detalle->venta_id = $venta_id;
            $detalle->producto_id = $value->articulo_id;
            $detalle->descuento = $value->descuento;
            $detalle->observacion = $value->observacion;
            $detalle->precio_venta = $value->precio_venta;
            $detalle->precio_compra = $value->articulo->precio_compra;
            $detalle->cantidad = $value->cantidad;
            
            $detalle->save();

            $detalleMovimiento = new DetalleMovimientosArticulos();
            if($request->tipo_documento == 41)
            {
                $detalleMovimiento->movimiento_id = 5; // 5 = Cotizacion
            }else{
                $detalleMovimiento->movimiento_id = 2; // 2 = ventas
            }
            $detalleMovimiento->id_movimiento = $venta_id;
            $detalleMovimiento->producto_id = $value->articulo_id;
            $detalleMovimiento->cantidad = $value->cantidad;
            $detalleMovimiento->usuario_id = Auth::user()->id;
            $detalleMovimiento->save();

            if($request->tipo_documento != 41)
            {
                $articulo = Articulo::find($value->articulo_id);
                $articulo->stock = $articulo->stock - $value->cantidad;
                $articulo->save();
            }

            $tipo_documento = tipo_documento::find($request->tipo_documento);
            $tipo_documento->ultima_emision = $request->numero_documento;
            $tipo_documento->save();
        }

        $ventaId = Ventas::max('id');

        $DetalleApertura = new DetalleAperturaCaja();

        // Busqueda para descontar el saldo del usuario correspondiente
        if($request->tipo_documento != 41){
            if($request->condicion == 0){ //contado = 0
                $apertura = DetalleAperturaCaja::where('caja_id', $request->caja_id)->latest()->first();
    
                $DetalleApertura->descripcion = 'Venta';
                $DetalleApertura->apertura_cajas_id = $apertura->apertura_cajas_id;
                $DetalleApertura->venta_id = $ventaId;
                // Validar cuando se deja un anticipo para guardar el movimiento como "Anticipo"
                $DetalleApertura->saldo_total = ($apertura->saldo_total + $request->monto_total);
                $DetalleApertura->caja_id = $request->caja_id;
                $DetalleApertura->save();
            }
            return redirect()->route('ventas.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Venta registrada correctamente',
                'tipo' => 'alert-success',
                'open_second_page' => route('ticket.venta', $venta->id)
            ]);
        }else{
            return redirect()->route('ventas.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Venta registrada correctamente',
                'tipo' => 'alert-success',
                'open_second_page' => route('pdf.venta', $venta->id)
            ]);
        }
    }

    public function show($id)
    {
        $detalleVentas = DetalleVentas::where('venta_id', $id)->get();
        $venta = Ventas::find($id);
        return view('ventas.view', compact(['detalleVentas', 'venta']));
    }
 
    public function destroy($id)
    {
        $venta = session('venta', []);

        // Filtra los elementos que no tienen el ID proporcionado
        $venta = array_filter($venta, function ($item) use ($id) {
            return $item->articulo_id != $id;
        });

        // Actualiza la sesión con el nuevo array
        session(['venta' => array_values($venta)]);

        return redirect()->route('ventas.create');
    }

    public function anularFactura(Ventas $venta)
    {
        $venta_detalles = DetalleVentas::where('venta_id', $venta->id)->get();
        $apertura = DetalleAperturaCaja::where('venta_id', $venta->id)->latest()->first();

        $id_cxc = CuentaxCobrar::where('venta_id', $venta->id)->first();

        if ($id_cxc) {
            $facturas_credito = $id_cxc;
            $facturas_credito->estado = 'Factura anulada';
            $facturas_credito->save();
        }

        if ($venta->estado === 1) {

            $venta->update(['estado' => 0]); // 1=Factura, 0=Anulado

            foreach ($venta_detalles as $detalle) {
                // Obtener el producto asociado al detalle de venta
                $producto = Articulo::find($detalle->producto_id);

                // Calcular el nuevo stock sumando la cantidad del detalle de venta
                $nuevo_stock = $producto->stock + $detalle->cantidad;
                
                // Actualizar el stock del producto
                $producto->update(['stock' => $nuevo_stock]);
            }

            // Crear el movimiento
            if($venta->condicion === 0){ // Contado = 0
                $saldo_total = $apertura->saldo_total - $venta->monto_total;
                DetalleAperturaCaja::create([
                    'descripcion' => 'Factura Anulada',
                    'egreso' => $venta->monto_total,
                    'apertura_cajas_id' => $apertura->apertura_cajas_id,
                    'saldo_total' => $saldo_total,
                    'caja_id' => $apertura->caja_id,
                ]);
            }
            
            return redirect()->back()->with([
                'error' => 'Exito',
                'mensaje' => 'La factura se anulo correctamente.',
                'tipo' => 'alert-success'
            ]);
        } else {
            return redirect()->back()->with([
                'error' => 'Error',
                'mensaje' => 'La factura ya ha sido anulada previamente.',
                'tipo' => 'alert-danger'
            ]);
        }
    }
}
