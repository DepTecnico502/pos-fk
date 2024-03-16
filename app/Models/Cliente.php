<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable =[
        'rut',
        'nombre',
        'direccion',
        'telefono',
        'mail'
    ];

    public function credito()
    {
        return $this->hasMany(CuentaxCobrar::class);
    }
}
