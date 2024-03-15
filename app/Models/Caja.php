<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = [
        'caja'
    ];

    public function user()
    {
        // Uno a muchos
        return $this->hasMany(User::class);
    }

    public function detalleApertura()
    {
        // Uno a muchos
        return $this->hasMany(DetalleAperturaCaja::class);
    }
}
