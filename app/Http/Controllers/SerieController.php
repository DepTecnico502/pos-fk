<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function index()
    {
        $series = Serie::all();

        return view('administracion.series.index', [
            'series' => $series
        ]);
    }

    public function create()
    {
        return view('administracion.series.create');
    }

    public function store(Request $request)
    {

        $serie = new Serie();
        $serie->serie = $request->serie;

        try {
            $serie->save();
 
            return redirect()->route('configuracion.series.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Serie '. $serie->serie. ' creado correctamente',
                'tipo' => 'alert-success'
            ]);
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect()->route('configuracion.series.create')->with([
                    'error' => 'Error',
                    'mensaje' => 'La serie ' .$serie->serie. ' ya existe: ' . $e->getMessage(),
                    'tipo' => 'alert-danger'
                ]);
            }
            return redirect()->route('configuracion.series.create')->with([
                'error' => 'Error',
                'mensaje' => 'La serie no pudo ser creado ' . $e->getMessage(),
                'tipo' => 'alert-danger'
            ]);
        }
    }

    public function edit($id)
    {
        $serie = Serie::find($id);

        return view('administracion.series.edit', [
            'serie' => $serie
        ]);
    }

    public function update(Request $request, Serie $serie)
    {
        try {
            // Actualiza los demás campos del artículo
            // $articulo->stock = $request->stock ?? 0;
            $serie->serie = $request->serie;
            $serie->save();

            return redirect()->route('configuracion.series.index')->with([
                'error' => 'Serie modificado correctamente',
                'tipo' => 'alert-primary'
            ]);
        } catch (\Exception $e) {
            // Maneja el error según sea necesario
            if ($e->getCode() == 23000) {
                return redirect()->route('configuracion.series.edit', $serie->id)->with([
                    'error' => 'Error',
                    'mensaje' => 'La serie ' .$serie->serie. ' ya existe: ' . $e->getMessage(),
                    'tipo' => 'alert-danger'
                ]);
            }
            return redirect()->route('configuracion.series.edit', $serie->id)->with([
                'error' => 'Error',
                'mensaje' => 'Error al modificar la serie ' . $e->getMessage(),
                'tipo' => 'alert-danger'
            ]);
        }
    }

}
