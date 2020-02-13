<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wish_lists', function (Blueprint $table) {
            $table->string('id')->primary('id');

            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });

        Schema::table('users', function($table) {
            $table->foreign('wishlist_id')->references('id')->on('wish_lists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wish_lists');
    }
}
