<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class import_detail extends Model
{
    //
    protected $table = 'import_detail';

    public function import()
	{
	    return $this->belongsTo('App\import', 'import_id', 'id');
	}
	public function product()
	{
	    return $this->belongsTo('App\products', 'product_id', 'id');
	}
}
