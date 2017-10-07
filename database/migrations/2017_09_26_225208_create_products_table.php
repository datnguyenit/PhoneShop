<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('manufacturer_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('alias')->nullable();
            $table->string('detail')->nullable();
            $table->string('image')->nullable();
            $table->double('unit_price')->default(0);
            $table->double('promotion_price')->default(0);
            $table->integer('quantity')->default(0);

            $table->string('OS')->nullable();
            $table->string('memory')->nullable();
            $table->string('RAM')->nullable();
            $table->string('display')->nullable();
            $table->string('color')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
