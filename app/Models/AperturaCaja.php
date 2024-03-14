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
        'user_id',
        'estado',
        'fecha_apertura'
    ];

    public function User(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
