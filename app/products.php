<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    //
    protected $table = 'products';

    public function manufacturer(){
    	return $this->belongsTo('App\manufacturers','manufacturer_id','id');
    }

    public function import_details()
	{
	    return $this->hasMany('App\import_detail', 'product_id', 'id');
	}

}
