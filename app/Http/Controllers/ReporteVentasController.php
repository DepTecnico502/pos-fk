<?php

namespace App\Http\Controllers;

use App\Models\DetalleVentas;
use App\Models\Pagos;
use App\Models\Recepciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteVentasController extends Controller
{
    public function ventas() {
        $reporte = DetalleVentas::all();
        return view('reportes.ventas', compact('reporte'));
    }

    public function saldos_resumen() {
        $saldosResumen = DB::table('recepciones as c')
        ->join('proveedors as p', 'c.proveedor_id', '=', 'p.id')
        ->select('p.nombre', DB::raw('SUM(c.saldo_pendiente) as saldo'))
        ->where('c.condicion', '!=', 0)
        ->where('c.saldo_pendiente', '>', 0)
        ->groupBy('p.nombre')
        ->get();
        
        return view('reportes.saldosResumen', compact('saldosResumen'));
    }

    public function saldos_pendientes() {
        $saldosPendientes = Recepciones::where('condicion', '!=', 0)
        ->where('saldo_pendiente', '>', 0)
        ->get();
        
        return view('reportes.saldosPendientes', compact('saldosPendientes'));
    }
}
