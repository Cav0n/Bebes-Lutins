<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_cart_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantity')->unsigned();
            

            $table->integer('product_id')->unsigned();
            $table->string('shopping_cart_id');

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('shopping_cart_id')->references('id')->on('shopping_carts');

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
        Schema::dropIfExists('shopping_cart_items');
    }
}
