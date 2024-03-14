<?php

namespace App\Exports;

use App\Models\Pagos;
use App\Models\Recepciones;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class saldosExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return Recepciones::query()
            ->whereDate('fecha_a_pagar', '>=', $this->startDate)
            ->whereDate('fecha_a_pagar', '<=', $this->endDate)
            ->where('condicion', '!=', 0)
            ->where('saldo_pendiente', '>', 0);
    }

    public function headings(): array
    {
        return [
            'Fecha de compra',
            'Proveedor',
            'Tipo de documento',
            'Documento',
            'Condición',
            'Días de crédito',
            'Fecha a pagar',
            'Unidades',
            'Monto',
            'Saldo pendiente',
            'Observaciones',
        ];
    }

    public function map($row): array
    {
        return [
            $row->fecha_recepcion,
            $row->proveedor->nombre,
            $row->documentos->tipo_documento,
            $row->documento,
            $row->condicion == 1 ? "Crédito" : "Contado",
            $row->dias_credito,
            $row->fecha_a_pagar,
            $row->unidades,
            $row->monto_total,
            $row->saldo_pendiente,
            $row->observaciones,
        ];
    }
}
