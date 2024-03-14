<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaxCobrar extends Model
{
    use HasFactory;

    protected $table = 'cuentas_x_cobrar';

    protected $fillable = [
        'venta_id',
        'cliente_id',
        'dias_credito',
        'fecha_pagar',
        'monto_total',
        'saldo_pendiente',
        'estado'
    ];
}