<?php

use Illuminate\Database\Seeder;
use App\bills;

class BillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        bills::truncate();
    	bills::insert([
    		[
    			'name' =>'Hóa đơn ngôi nhà ma',
    			'phone' => '0985650547',
    			'address' => 'Hẻm Nhà thờ, Võ Văn Ngân, Thủ Đức',
    			'status' => 1,
    			'email' => 'truongthanhquang96@gmail.com',
    			'created_at' => new DateTime()
    		],
    	]);
    }
}
