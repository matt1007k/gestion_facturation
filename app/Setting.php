<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['sfs_url'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
