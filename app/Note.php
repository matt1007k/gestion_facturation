<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['tipo_operacion', 'description', 'note_id', 'venta_id'];

    public function venta()
    {
        return $this->belongsTo('App\Venta');
    }
}
