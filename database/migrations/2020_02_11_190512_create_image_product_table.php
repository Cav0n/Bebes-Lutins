<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageProductTable extends Migration
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
            $table->integer('rank')->unsigned()->default(0);
            $table->bigInteger('image_id')->unsigned();
            $table->string('product_id');

            $table->foreign('image_id')
                    ->references('id')->on('images')
                    ->onDelete('cascade');

            $table->foreign('product_id')
                    ->references('id')->on('products')
                    ->onDelete('cascade');

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
