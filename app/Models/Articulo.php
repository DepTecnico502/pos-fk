<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

    protected $fillable =[
        'id',
        'cod_interno',
        'cod_barras',
        'descripcion',
        'id_categoria',
        'precio_venta',
        'precio_compra',
        'stock',
        'url_imagen',
        'stock_critico',
        'estado'
    ];

    public function Categoria(){
        return $this->hasOne(CategoriaProducto::class, 'id', 'id_categoria');
    }
}
