<?php

use Illuminate\Database\Seeder;
use App\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::truncate();   
    	User::insert([
    		[
    			'name' => 'Dat',
    			'email' => 'datnguyen.ute@gmail.com',
    			'role_id'=> 1,
    			'password' => bcrypt('123456'),
    			'phone' => '01652729542',
    			'status' => 1
    		],
    		[
    			'name' => 'Heo',
    			'email' => 'heout@gmail.com',
    			'role_id'=> 2,
    			'password' => bcrypt('123456'),
    			'phone' => '0968862522',
    			'status' => 1
    		],
    	]);
    }
}
