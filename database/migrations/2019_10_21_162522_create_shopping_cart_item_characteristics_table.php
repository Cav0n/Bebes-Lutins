<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingCartItemCharacteristicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_cart_item_characteristics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('selectedOptionName');

            $table->bigInteger('shopping_cart_item_id')->unsigned();

            $table->foreign('shopping_cart_item_id')->references('id')->on('shopping_cart_items');
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
        Schema::dropIfExists('shopping_cart_item_characteristics');
    }
}
