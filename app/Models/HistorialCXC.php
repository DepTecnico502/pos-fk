<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialCXC extends Model
{
    use HasFactory;

    protected $table = 'historial_pagos_cxc';

    protected $fillable = [
        'cxc_id',
        'monto_abonado'
    ];

    public function cxc()
    {
        return $this->belongsTo(CuentaxCobrar::class);
    }
}
