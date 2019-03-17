<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $filable = [
        'tipo',               
        'num_comprobante',   
        'fecha_emision',
        'tipo_doc',
        'num_doc',
        'nombre',
        'direccion',
        'subtotal',
        'igv' ,
        'total'
    ];

    public function details(){
        return $this->hasMany('App\Detalle');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
