<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImageProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('image_id')->unsigned();
            $table->integer('product_id')->unsigned();

            $table->foreign('image_id')->references('id')->on('images');
            $table->foreign('product_id')->references('id')->on('products');

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
        Schema::dropIfExists('image_product');
    }
}
