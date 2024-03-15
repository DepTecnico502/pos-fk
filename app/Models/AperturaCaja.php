<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AperturaCaja extends Model
{
    use HasFactory;

    protected $fillable =[
        'id',
        'saldo_inicial',
        'saldo_total',
        'saldo_faltante',
        'saldo_sobrante',
        'arqueo_caja',
        'caja_id',
        'user_id',
        'estado',
        'fecha_apertura'
    ];

    public function User(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function caja()
    {
        // Uno a Uno
        return $this->belongsTo(Caja::class);
    }
}
