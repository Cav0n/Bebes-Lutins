<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoryImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_image', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category_id');
            $table->bigInteger('image_id')->unsigned();

            $table->foreign('category_id')
                    ->references('id')->on('categories')
                    ->onDelete('cascade');

            $table->foreign('image_id')
                    ->references('id')->on('images')
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
        //
    }
}
