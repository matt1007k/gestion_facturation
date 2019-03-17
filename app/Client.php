<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
   protected $fillable = ['nombre', 'tipo_doc', 'num_doc', 'direccion'];


   public function scopeNombre($query, $texto){
      if ($texto)
         return $query->where('nombre', 'LIKE', "%$texto%")
                     ->orWhere('num_doc', 'LIKE', "%$texto%");
   }

   public function user(){
      return $this->belongsTo('App\User');
   }
}
