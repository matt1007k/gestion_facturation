<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{

    protected $filable = [
        'cantidad',         
        'nombre', 
        'descripcion',
        'precio',
        'unidad',
        'descuento',
        'subtotal'
    ];
    public function venta(){
        return $this->belongsTo('App\Detalle');
    }
}
