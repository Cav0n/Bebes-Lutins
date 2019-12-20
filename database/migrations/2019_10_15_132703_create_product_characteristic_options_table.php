<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCharacteristicOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_characteristic_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->integer('product_characteristic_id')->unsigned();

            $table->foreign('product_characteristic_id')->references('id')->on('product_characteristics');
            
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
        Schema::dropIfExists('product_characteristic_options');
    }
}
