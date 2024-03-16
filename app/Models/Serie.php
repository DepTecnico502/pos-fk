<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    protected $table = 'serie';

    protected $fillable = [
        'serie',
        'secuencia'
    ];

    public function articulo()
    {
        // Uno a muchos
        return $this->hasMany(Articulo::class);
    }
}
