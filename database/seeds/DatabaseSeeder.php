<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(ManufacturerTableSeeder::class);
        // $this->call(ProductTableSeeder::class);
        // $this->call(RoleTableSeeder::class);
        // $this->call(UserTableSeeder::class);


        $this->call(ImportDetailTableSeeder::class);
    }
}
