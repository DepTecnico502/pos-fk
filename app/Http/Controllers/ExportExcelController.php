<?php

namespace App\Http\Controllers;

use App\Exports\pagosExport;
use App\Exports\saldosExport;
use App\Exports\saldosResumenExport;
use App\Exports\ventasExport;
use Illuminate\Http\Request;

class ExportExcelController extends Controller
{
    public function export(Request $request)
    {   
        $fecha_desde = $request->fecha_desde;
        $fecha_hasta = $request->fecha_hasta;

        return (new ventasExport($fecha_desde, $fecha_hasta))->download('ventas.xlsx');
    }

    public function pagosExport(Request $request)
    {   
        $fecha_desde = $request->fecha_desde;
        $fecha_hasta = $request->fecha_hasta;

        return (new pagosExport($fecha_desde, $fecha_hasta))->download('pagos.xlsx');
    }

    public function saldosExport(Request $request)
    {   
        $fecha_desde = $request->fecha_desde;
        $fecha_hasta = $request->fecha_hasta;

        return (new saldosExport($fecha_desde, $fecha_hasta))->download('saldos_pendientes_por_pagar.xlsx');
    }

    public function saldosResumenExport()
    {
        return (new saldosResumenExport())->download('saldos_resumen.xlsx');
    }
}
