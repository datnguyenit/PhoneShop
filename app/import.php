<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class import extends Model
{
    //
    protected $table = 'import';

    public function import_details()
	{
	    return $this->hasMany('App\import_detail', 'import_id', 'id');
	}
}
