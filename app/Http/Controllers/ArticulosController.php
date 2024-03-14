<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\CategoriaProducto;
use App\Models\Proveedor;
use App\Models\tipo_documento;
use App\Models\DetalleMovimientosArticulos;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ArticulosController extends Controller
{

    public function index()
    {
        $articulos = Articulo::with('Categoria')->get();
        return view('articulos.index', compact('articulos'));
    }

    public function create()
    {
        $categorias = CategoriaProducto::all();

        return view('articulos.crear', compact('categorias'));
    }

    public function store(Request $request)
    {
        $articulo = new Articulo();
        $articulo->cod_interno = $request->cod_interno;
        $articulo->descripcion = $request->descripcion;
        $articulo->id_categoria = $request->id_categoria;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->precio_compra = $request->precio_compra ?? 0;
        $articulo->stock = $request->stock ?? 0;
        if ($request->hasFile('url_imagen')) {
            $image = $request->file('url_imagen');
            $image_name = "/img_articulos/" . Str::random(65) . "." . $image->getClientOriginalExtension();
            $image->move(public_path('img_articulos'), $image_name);

            $articulo->url_imagen = $image_name;
        }
        $articulo->estado = $request->estado;

        try {
            $articulo->save();
            if (session('recepcion')) {
                $proveedores = Proveedor::all();
                $articulos = Articulo::all();
                $tipo_documento = tipo_documento::all();

                return view('recepciones.create', compact(['proveedores', 'articulos', 'tipo_documento']))->with([
                    'error' => 'Exito',
                    'mensaje' => 'Artículo creado correctamente',
                    'tipo' => 'alert-success'
                ]);
            }
            return redirect()->route('articulos.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Artículo creado correctamente',
                'tipo' => 'alert-success'
            ]);
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect()->route('articulos.create')->with([
                    'error' => 'Error',
                    'mensaje' => 'El artículo ya existe' . $e->getMessage(),
                    'tipo' => 'alert-danger'
                ]);
            }
            return redirect()->route('articulos.create')->with([
                'error' => 'Error',
                'mensaje' => 'El artículo no pudo ser creado' . $e->getMessage(),
                'tipo' => 'alert-danger'
            ]);
        }
    }

    public function show($articulo)
    {
        $articulo = Articulo::find($articulo);
        $categorias = CategoriaProducto::all();
        return view('articulos.editar', compact(['articulo', 'categorias']));
    }

    public function update(Request $request, Articulo $articulo)
    {
        try {
            // Eliminar la imagen actual si se proporciona una nueva imagen
            if ($request->hasFile('url_imagen')) {
                // Verifica si hay una imagen actual asociada al artículo
                if ($articulo->url_imagen) {
                    $imagenActual = public_path($articulo->url_imagen);

                    // Elimina la imagen actual
                    if (File::exists($imagenActual)) {
                        File::delete($imagenActual);
                    }
                }

                // Sube y guarda la nueva imagen
                $imagen = $request->file('url_imagen');
                $imagenNombre = "/img_articulos/" . Str::random(65) . "." . $imagen->getClientOriginalExtension();
                $imagen->move(public_path('img_articulos'), $imagenNombre);

                // Asigna la ruta de la nueva imagen al campo correspondiente en el modelo
                $articulo->url_imagen = $imagenNombre;
            }

            // Actualiza los demás campos del artículo
            $articulo->cod_interno = $request->cod_interno;
            $articulo->descripcion = $request->descripcion;
            $articulo->id_categoria = $request->id_categoria;
            $articulo->precio_venta = $request->precio_venta;
            $articulo->precio_compra = $request->precio_compra ?? 0;
            $articulo->stock = $request->stock ?? 0;
            $articulo->estado = $request->estado;

            $articulo->save();

            return redirect()->route('articulos.index')->with([
                'error' => 'Artículo modificado correctamente',
                'tipo' => 'alert-primary'
            ]);
        } catch (\Exception $e) {
            // Maneja el error según sea necesario
            $categorias = CategoriaProducto::all();
            return view('articulos.editar', compact(['articulo', 'categorias']))->with([
                'error' => 'Error al modificar el artículo',
                'mesaje' => 'Error al modificar el artículo',
                'tipo' => 'alert-danger'
            ]);
        }
    }

    public function getHistorialArticulo($id)
    {
        $articulo = Articulo::find($id);
        $historial = DetalleMovimientosArticulos::where('producto_id', $id)->get();
        return view('articulos.historial', compact(['articulo', 'historial']));
    }
}
