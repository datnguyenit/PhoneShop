<?php

use Illuminate\Database\Seeder;
use App\import;
class ImportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        import::truncate();
    	import::insert([
    		[
    			'user_id' =>5,
    			'total_quantity' => 1,
    			'total_price' => 2500000,
    			'status' => 1,
    		],
    		[
    			'user_id' =>5,
    			'total_quantity' => 2,
    			'total_price' => 5500000,
    			'status' => 1,
    		]
    	]);
    }
}
