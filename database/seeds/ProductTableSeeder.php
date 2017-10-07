<?php

use Illuminate\Database\Seeder;
use App\products;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        products::truncate();
        products::insert(
        [
        	[
        	'manufacturer_id'=>1,
        	'name'=>'Iphone X',
        	'alias'=>'iphone-x',
        	'detail'=>'iphone-x đẹp long lanh',
        	'image'=>'iphonex.png',
        	'unit_price'=>32000000,
        	'promotion_price'=>0,
        	'quantity'=>1,
        	'OS'=>'IOS 11',
        	'memory'=>'64GB',
        	'RAM'=>'3GB',
        	'display'=>'6 inch',
        	'color'=>'Black',
        	'status'=>1
        	],
        	[
        	'manufacturer_id'=>1,
        	'name'=>'Iphone 8',
        	'alias'=>'iphone-8',
        	'detail'=>'iphone-8 đẹp bụi',
        	'image'=>'ip7plus_den.jpg',
        	'unit_price'=>27500000,
        	'promotion_price'=>0,
        	'quantity'=>1,
        	'OS'=>'IOS 11',
        	'memory'=>'64GB',
        	'RAM'=>'2.5GB',
        	'display'=>'5 inch',
        	'color'=>'Rose Gold',
        	'status'=>1
        	],
        	[
        	'manufacturer_id'=>2,
        	'name'=>'Samsung Note 8',
        	'alias'=>'note-8',
        	'detail'=>'note 8 đẹp huyền ảo',
        	'image'=>'ssgalaxya7_hong.jpg',
        	'unit_price'=>26600000,
        	'promotion_price'=>0,
        	'quantity'=>1,
        	'OS'=>'Android 7.0',
        	'memory'=>'64GB',
        	'RAM'=>'4GB',
        	'display'=>'6 inch',
        	'color'=>'Black',
        	'status'=>1
        	],
        	[
        	'manufacturer_id'=>2,
        	'name'=>'Samsung S8',
        	'alias'=>'samsung-s8',
        	'detail'=>'samsung s8 đẹp mù mắt',
        	'image'=>'ssgalaxys7_den.jpg',
        	'unit_price'=>22000000,
        	'promotion_price'=>0,
        	'quantity'=>1,
        	'OS'=>'Android 7.0',
        	'memory'=>'64GB',
        	'RAM'=>'4GB',
        	'display'=>'5.1 inch',
        	'color'=>'Black',
        	'status'=>1
        	],
        ]
        );
    }
}
