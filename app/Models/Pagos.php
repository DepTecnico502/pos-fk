<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable =[
        'fecha',
        'compra_id',
        'medio_pago_id',
        'tipo_documentos_id',
        'documento',
        'observaciones',
        'monto',
        'url_imagen',
        'user_id'
    ];

    public function compras(){
        return $this->hasOne(Recepciones::class, 'id', 'compra_id');
    }

    public function mediosdepagos(){
        return $this->hasOne(mediosdepago::class, 'id', 'medio_pago_id');
    }

    public function tipo_documentos(){
        return $this->hasOne(tipo_documento::class, 'id', 'tipo_documentos_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
