<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProducto;
use Illuminate\Http\Request;

class CategoriaProductoController extends Controller
{
    public function index() {
        $categorias = CategoriaProducto::all();
        return view('categorias.index', compact('categorias'));
    }

    public function create(){
        return view('categorias.crear');
    }

    public function store(Request $request) {

        $articulo = new CategoriaProducto();
        $articulo->nombre_categoria = $request->nombre_categoria;

        try {
            $articulo->save();
            return redirect()->route('categoria.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Categoría creada correctamente',
                'tipo' => 'alert-success'
            ]);
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect()->route('categoria.create')->with([
                    'error' => 'Error',
                    'mensaje' => 'La categoría ya existe' . $e->getMessage(),
                    'tipo' => 'alert-danger'
                ]);
            }
            return redirect()->route('categoria.create')->with([
                'error' => 'Error',
                'mensaje' => 'La categoría no pudo ser creada' . $e->getMessage(),
                'tipo' => 'alert-danger'
            ]);
        }
    }

    public function edit($categoria) {
        $categoria = CategoriaProducto::find($categoria);
        return view('categorias.editar', compact('categoria'));
    }

    public function update(Request $request, CategoriaProducto $categoria){
        $categoria->nombre_categoria = $request->nombre_categoria;

        try {
            $categoria->save();

            return redirect()->route('categoria.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Categoría modificada correctamente',
                'tipo' => 'alert-primary'
            ]);
        } catch (\Exception $e) {
            return view('categoria.editar', compact('categoria'));
        }
    }
}
