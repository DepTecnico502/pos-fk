<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAperturaCaja extends Model
{
    use HasFactory;

    protected $fillable =[
        'id',
        'descripcion',
        'ingreso',
        'egreso',
        'apertura_cajas_id',
        'venta_id',
        'recepciones_id',
        'saldo_total',
        'caja_id'
    ];

    public function Apertura() {
        return $this->belongsTo(AperturaCaja::class, 'apertura_cajas_id', 'id');
    }

    public function Venta() {
        return $this->belongsTo(Ventas::class, 'venta_id', 'id');
    }

    public function Recepcion() {
        return $this->belongsTo(Recepciones::class, 'recepciones_id', 'id');
    }

    public function caja()
    {
        // Uno a Uno
        return $this->belongsTo(Caja::class);
    }
}
