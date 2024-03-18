<?php

namespace App\Http\Controllers;

use App\Models\CuentaxCobrar;
use Illuminate\Http\Request;

class CuentaXCobrarController extends Controller
{
    public function index()
    {
        $facturas = CuentaxCobrar::where('estado', '!=', 'Cuenta pagada')->get();

        return view('facturas-credito.index', [
            'facturas' => $facturas
        ]);
    }
}
