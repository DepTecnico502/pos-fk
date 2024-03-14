<?php

namespace App\Http\Controllers;

use App\Models\AjustesDeInventario;
use App\Models\Articulo;
use App\Models\Tipo_movimiento;
use App\Models\DetalleAjustesDeInventario;
use App\Models\DetalleMovimientosArticulos;
use Illuminate\Http\Request;

class AjustesDeInventarioController extends Controller
{
    public function index()
    {
        if (session('ajuste')) {
            session()->forget('ajuste');
        }
        $ajustesDeInventario = AjustesDeInventario::all();
        return view('ajustes-de-inventario.index', compact('ajustesDeInventario'));
    }

    public function addArticulo(Request $request)
    {
        if ($request->salidas == 0 && $request->entradas == 0) {
            return redirect()->route('ajustesdeinventario.create')->with([
                'error' => 'Error',
                'mensaje' => 'Las entradas y salidas no pueden ser iguales',
                'tipo' => 'alert-danger'
            ]);
        } else {
            $ajuste_new = [];
            $ajuste_flag = false;
            if (session('ajuste')) {

                foreach (session('ajuste') as $value) {
                    if ($value['articulo_id'] == $request->articulo) {
                        $ajuste_tmp = new DetalleAjustesDeInventario();

                        $ajuste_tmp->articulo = Articulo::find($request->articulo);
                        $ajuste_tmp->articulo_id = $request->articulo;
                        $ajuste_tmp->salidas = $request->salidas;
                        $ajuste_tmp->entradas = $request->entradas;
                        $ajuste_tmp->precio_venta = $request->precio_venta;
                        array_push($ajuste_new, $ajuste_tmp);
                        $ajuste_flag = true;
                    } else {
                        $ajuste_tmp = new DetalleAjustesDeInventario();
                        $ajuste_tmp->articulo = Articulo::find($value->articulo_id);
                        $ajuste_tmp->articulo_id = $value->articulo_id;
                        $ajuste_tmp->salidas = $value->salidas;
                        $ajuste_tmp->entradas = $value->entradas;
                        $ajuste_tmp->precio_venta = $value->precio_venta;
                        array_push($ajuste_new, $ajuste_tmp);
                    }
                }
                if ($ajuste_flag == false) {
                    $ajuste_tmp = new DetalleAjustesDeInventario();

                    $ajuste_tmp->articulo = Articulo::find($request->articulo);
                    $ajuste_tmp->articulo_id = $request->articulo;
                    $ajuste_tmp->salidas = $request->salidas;
                    $ajuste_tmp->entradas = $request->entradas;
                    $ajuste_tmp->precio_venta = $request->precio_venta;
                    array_push($ajuste_new, $ajuste_tmp);
                }
                session(['ajuste' => $ajuste_new]);
            } else {
                $ajuste_tmp = new DetalleAjustesDeInventario();

                $ajuste_tmp->articulo = Articulo::find($request->articulo);
                $ajuste_tmp->articulo_id = $request->articulo;
                $ajuste_tmp->salidas = $request->salidas;
                $ajuste_tmp->entradas = $request->entradas;
                $ajuste_tmp->precio_venta = $request->precio_venta;
                array_push($ajuste_new, $ajuste_tmp);
                session(['ajuste' => $ajuste_new]);
            }

            return redirect()->route('ajustesdeinventario.create')->with([
                'error' => 'Exito',
                'mensaje' => 'Se agrego el artículo al ajuste',
                'tipo' => 'alert-success'
            ]);
        }
    }

    public function create()
    {
        $articulos = Articulo::all();
        $tipo_movimientos = Tipo_movimiento::all();
        return view('ajustes-de-inventario.create', compact(['articulos', 'tipo_movimientos']));
    }

    public function store(Request $request)
    {
        $ajuste = new AjustesDeInventario();
        $ajuste->monto_total = $request->monto_total;
        $ajuste->entradas = $request->total_entradas;
        $ajuste->salidas = $request->total_salidas;
        $ajuste->tipo_movimiento_id = $request->tipo_movimiento;
        $ajuste->observaciones = $request->observaciones;
        $ajuste->user_id = auth()->user()->id;
        $ajuste->save();
        $detalle = session('ajuste');
        foreach ($detalle as $value) {
            $ajuste_detalle = new DetalleAjustesDeInventario();
            $ajuste_detalle->ajuste_de_inventario_id = $ajuste->id;
            $ajuste_detalle->articulo_id = $value->articulo_id;
            $ajuste_detalle->salidas = $value->salidas;
            $ajuste_detalle->entradas = $value->entradas;
            $ajuste_detalle->precio_venta = $value->precio_venta;
            $ajuste_detalle->save();

            $articulo = Articulo::find($value->articulo_id);
            if ($value->entradas > 0) {
                $articulo->stock = $articulo->stock + $value->entradas;
            } else {
                $articulo->stock = $articulo->stock - $value->salidas;
            }
            $articulo->save();

            $movimiento = new DetalleMovimientosArticulos();
            $movimiento->producto_id = $value->articulo_id;
            $movimiento->id_movimiento = $ajuste->id;
            $movimiento->movimiento_id = $ajuste->tipo_movimiento_id;
            if ($value->entradas > 0) {
                $movimiento->cantidad = $value->entradas;
            } else {
                $movimiento->cantidad = $value->salidas * -1;
            }
            $movimiento->usuario_id = auth()->user()->id;
            $movimiento->save();
        }
        session()->forget('ajuste');
        return redirect()->route('ajustesdeinventario.index')->with([
            'error' => 'Exito',
            'mensaje' => 'Se agrego el ajuste de inventario',
            'tipo' => 'alert-success'
        ]);
    }

    public function view($id)
    {
        $ajuste = AjustesDeInventario::find($id);
        if ($ajuste == null) {
            return redirect()->route('ajustesdeinventario.index')->with([
                'error' => 'Error',
                'mensaje' => 'No se encontro el ajuste de inventario',
                'tipo' => 'alert-danger'
            ]);
        }
        $detalle = DetalleAjustesDeInventario::where('ajuste_de_inventario_id', $id)->get();
        return view('ajustes-de-inventario.view', compact(['ajuste', 'detalle']));
    }

    public function destroy($cod_interno)
    {
        $ajuste = session('ajuste', []);
    
        // Filtra los elementos que no tienen el cod_interno proporcionado
        $ajuste = array_filter($ajuste, function ($item) use ($cod_interno) {
            return $item->articulo->cod_interno != $cod_interno;
        });
    
        // Actualiza la sesión con el nuevo array
        session(['ajuste' => array_values($ajuste)]);
    
        return redirect()->route('ajustesdeinventario.create');
    }
}
