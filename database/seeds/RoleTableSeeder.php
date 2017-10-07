<?php

use Illuminate\Database\Seeder;
use App\roles;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        roles::truncate();
    	roles::insert([
    		[
    			'name' => 'MasterAdmin'
    		],
    		[
    			'name' => 'Admin'
    		],
    	]);
    }
}
