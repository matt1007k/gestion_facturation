<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code',
        'name', 
        'price', 
        'description', 
        'quantity', 
        'unity', 
        'img', 
        'status'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}