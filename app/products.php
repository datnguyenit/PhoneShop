<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    //
    protected $table = 'products';

    public function manufacturers(){
    	return $this->belongsTo('App\manufacturers','manufacturer_id','id');
    }
}
