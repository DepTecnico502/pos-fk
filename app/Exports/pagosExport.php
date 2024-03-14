<?php

namespace App\Exports;

use App\Models\Pagos;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class pagosExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return Pagos::query()
            ->whereDate('fecha', '>=', $this->startDate)
            ->whereDate('fecha', '<=', $this->endDate);
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Proveedor',
            'Monto pagado',
            'Tipo de documento',
            'Número de documento',
            'Comentario',
            'Fotografía'
        ];
    }

    public function map($row): array
    {
        return [
            $row->fecha,
            $row->compras->proveedor->nombre,
            $row->monto,
            $row->tipo_documentos->tipo_documento,
            $row->documento,
            $row->observaciones,
            asset($row->url_imagen),
        ];
    }
}
