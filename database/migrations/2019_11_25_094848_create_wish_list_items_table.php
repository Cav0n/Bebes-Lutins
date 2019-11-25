<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishListItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wish_list_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('product_id');
            $table->string('wish_list_id');

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('wish_list_id')->references('id')->on('wish_lists');

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
        Schema::dropIfExists('wish_list_items');
    }
}
