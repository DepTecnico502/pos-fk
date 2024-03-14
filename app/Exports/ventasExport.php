<?php

namespace App\Exports;

use App\Models\DetalleVentas;
use App\Models\Pagos;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ventasExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return DetalleVentas::query()
            ->whereDate('created_at', '>=', $this->startDate)
            ->whereDate('created_at', '<=', $this->endDate);
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Cliente',
            'Código',
            'Descripción',
            'Descuento %',
            'Precio De Venta',
            'Precio De Compra',
            'Cantidad',
            'Ganancias',
        ];
    }

    public function map($row): array
    {
        return [
            $row->created_at,
            $row->venta->cliente->nombre,
            $row->producto->cod_interno,
            $row->producto->descripcion,
            $row->descuento,
            $row->precio_venta,
            $row->precio_compra,
            $row->cantidad,
            ($row->precio_venta - $row->precio_compra) * $row->cantidad,
        ];
    }
}
