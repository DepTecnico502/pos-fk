<?php

namespace App\Http\Controllers;

use App\Models\CuentaxCobrar;
use Illuminate\Http\Request;

class CuentaXCobrarController extends Controller
{
    public function index()
    {
        $facturas = CuentaxCobrar::all();

        return view('facturas-credito.index', [
            'facturas' => $facturas
        ]);
    }
}
