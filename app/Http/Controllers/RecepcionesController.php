<?php

namespace App\Http\Controllers;

use App\Models\AperturaCaja;
use App\Models\DetalleRecepcion;
use App\Models\Recepciones;
use App\Models\Articulo;
use App\Models\DetalleAperturaCaja;
use App\Models\Proveedor;
use App\Models\tipo_documento;
use App\Models\DetalleMovimientosArticulos;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RecepcionesController extends Controller
{
    public function index()
    {
        if (session('recepcion')) {
            session()->forget('recepcion');
        }
        $recepciones = Recepciones::all();
        return view('recepciones.index', compact('recepciones'));
    }

    public function view($id)
    {
        $recepcion = Recepciones::find($id);
        if ($recepcion == null) {
            return redirect()->route('recepciones.index')->with([
                'error' => 'Error',
                'mensaje' => 'Recepcion no encontrada',
                'tipo' => 'alert-danger'
            ]);
        }

        $detalle = DetalleRecepcion::where('recepcion_id', $id)->get();
        return view('recepciones.view', compact(['recepcion', 'detalle']));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $articulos = Articulo::all();
        $idsBusqueda = [33, 39, 41, 99];
        $tipo_documento = tipo_documento::whereIn('id', $idsBusqueda)->get();

        return view('recepciones.create', compact('proveedores', 'articulos', 'tipo_documento'));
    }

    public function addArticulo(Request $request)
    {
        $recepcion_new = [];
        $recepcion_flag = false;
        if (session('recepcion')) {
            $recepcion = session('recepcion');

            foreach (session('recepcion') as $value) {
                if ($value['articulo_id'] == $request->articulo) {
                    $recepcion_tmp = new DetalleRecepcion();

                    $recepcion_tmp->articulo = Articulo::find($request->articulo);
                    $recepcion_tmp->articulo_id = $request->articulo;
                    $recepcion_tmp->cantidad = $request->unidades + $value['cantidad'];
                    $recepcion_tmp->precio_unitario = $request->precio_compra;
                    $recepcion_tmp->total = $request->precio_compra * $request->unidades;
                    array_push($recepcion_new, $recepcion_tmp);
                    $recepcion_flag = true;
                } else {
                    $recepcion_tmp = new DetalleRecepcion();

                    $recepcion_tmp->articulo = Articulo::find($value->articulo_id);
                    $recepcion_tmp->articulo_id = $value->articulo_id;
                    $recepcion_tmp->cantidad = $value['cantidad'];
                    $recepcion_tmp->precio_unitario = $value['precio_unitario'];
                    $recepcion_tmp->total = $value['total'];
                    array_push($recepcion_new, $recepcion_tmp);
                }
            }
            if ($recepcion_flag == false) {
                $recepcion_tmp = new DetalleRecepcion();

                $recepcion_tmp->articulo = Articulo::find($request->articulo);
                $recepcion_tmp->articulo_id = $request->articulo;
                $recepcion_tmp->cantidad = $request->unidades;
                $recepcion_tmp->precio_unitario = $request->precio_compra;
                $recepcion_tmp->total = $request->precio_compra * $request->unidades;
                array_push($recepcion_new, $recepcion_tmp);
            }
            session(['recepcion' => $recepcion_new]);
        } else {
            $recepcion = new DetalleRecepcion();
            $recepcion->articulo = Articulo::find($request->articulo);
            $recepcion->articulo_id = $request->articulo;
            $recepcion->cantidad = $request->unidades;
            $recepcion->precio_unitario = $request->precio_compra;
            $recepcion->total = $request->precio_compra * $request->unidades;
            array_push($recepcion_new, $recepcion);
            session(['recepcion' => $recepcion_new]);
        }

        $proveedores = Proveedor::all();
        $articulos = Articulo::all();
        $idsBusqueda = [33, 39, 41, 99];
        $tipo_documento = tipo_documento::whereIn('id', $idsBusqueda)->get();

        return view('recepciones.create', compact(['proveedores', 'articulos', 'tipo_documento']));
    }

    public function store(Request $request)
    {

        $recepcion = new Recepciones();
        $recepcion->fecha_recepcion =$request->fecha_recepcion;
        $recepcion->proveedor_id = $request->proveedor;
        $recepcion->documento = $request->numero_documento;
        $recepcion->tipo_documentos_id = $request->tipo_documento;
        $recepcion->condicion = $request->condicion;

        if($request->condicion == 1){
            $recepcion->dias_credito =$request->dias_credito;
            $recepcion->fecha_a_pagar =$request->fecha_a_pagar;
            $recepcion->saldo_pendiente =$request->monto_total;
        }

        $recepcion->unidades = $request->total_articulos;
        $recepcion->monto_total = $request->monto_total;
        $recepcion->observaciones = $request->observaciones;

        // Almacenar imagenes
        if ($request->hasFile('url_imagen')) {
            $image = $request->file('url_imagen');
            $image_name = "/img_compras/" . Str::random(65) . "." . $image->getClientOriginalExtension();
            $image->move(public_path('img_compras'), $image_name);

            $recepcion->url_imagen = $image_name;
        }

        //$recepcion->url_imagen = $request->url_imagen;
        // $recepcion->fecha_recepcion = Carbon::now()->format('Y-m-d');
        $recepcion->user_id = Auth::user()->id;
        $recepcion->timestamps = false;
        $recepcion->save();
        $detalle = session('recepcion');

        foreach ($detalle as $value) {
            $detalle_recepcion = new DetalleRecepcion();
            $detalle_recepcion->recepcion_id = $recepcion->id;
            $detalle_recepcion->producto_id = $value->articulo_id;
            $detalle_recepcion->cantidad = $value->cantidad;
            $detalle_recepcion->precio_compra = $value->precio_unitario;
            $detalle_recepcion->save();

            $articulo = Articulo::find($value->articulo_id);
            $articulo->stock = $articulo->stock + $value->cantidad;
            $articulo->precio_compra = $value->precio_unitario;
            $articulo->save();

            $detalleMovimiento = new DetalleMovimientosArticulos();
            $detalleMovimiento->movimiento_id = 1; // 1 = recepciones
            $detalleMovimiento->id_movimiento = $recepcion->id;
            $detalleMovimiento->producto_id = $value->articulo_id;
            $detalleMovimiento->cantidad = $value->cantidad;
            $detalleMovimiento->usuario_id = Auth::user()->id;
            $detalleMovimiento->save();
        }
        session()->forget('recepcion');

        //Guardar reporte de caja
        // $aperturaId = AperturaCaja::max('id');
        // $compraId = Recepciones::max('id');

        // $DetalleApertura = new DetalleAperturaCaja();
        
        // $detalleId = DetalleAperturaCaja::max('id');
        // $saldo = DetalleAperturaCaja::findOrFail($detalleId);

        // $DetalleApertura->descripcion = 'Compra';
        // $DetalleApertura->apertura_cajas_id = $aperturaId;
        // $DetalleApertura->recepciones_id = $compraId;
        // $DetalleApertura->saldo_total = ($saldo->saldo_total - $request->monto_total);
        // $DetalleApertura->save();
        
        return redirect()->route('recepciones.index')->with([
            'error' => 'Exito',
            'mensaje' => 'Recepción creada correctamente con el numero ' . $recepcion->id,
            'tipo' => 'alert-success'
        ]);
    }

    public function destroy($id)
    {
        $recepcion = session('recepcion', []);

        // Filtra los elementos que no tienen el ID proporcionado
        $recepcion = array_filter($recepcion, function ($item) use ($id) {
            return $item->articulo->id != $id;
            // return $item->articulo_id != $articulo_id;
        });

        // Actualiza la sesión con el nuevo array
        session(['recepcion' => array_values($recepcion)]);

        return redirect()->route('recepciones.create');
    }
}
