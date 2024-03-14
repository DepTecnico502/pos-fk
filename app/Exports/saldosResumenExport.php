<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class saldosResumenExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function query()
    {
        return DB::table('recepciones as c')
            ->join('proveedors as p', 'c.proveedor_id', '=', 'p.id')
            ->select('p.nombre', DB::raw('SUM(c.saldo_pendiente) as saldo'))
            ->where('c.condicion', '!=', 0)
            ->where('c.saldo_pendiente', '>', 0)
            ->groupBy('p.nombre')
            ->orderBy('p.nombre');;
    }

    public function headings(): array
    {
        return [
            'Proveedor',
            'Saldos',
        ];
    }

    public function map($row): array
    {
        return [
            $row->nombre,
            $row->saldo
        ];
    }
}
