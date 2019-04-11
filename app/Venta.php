<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Venta extends Model
{
    protected $filable = [
        'estado',
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

    public function scopeComprobante($query, $tipo){
        if ($tipo)
            return $query->where('user_id', Auth::id())
                            ->where('tipo', $tipo);
    }
}
