<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemCharacteristicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item_characteristics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('selectedOptionName');

            $table->bigInteger('order_item_id')->unsigned();

            $table->foreign('order_item_id')->references('id')->on('order_items');

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
        Schema::dropIfExists('order_item_characteristics');
    }
}
