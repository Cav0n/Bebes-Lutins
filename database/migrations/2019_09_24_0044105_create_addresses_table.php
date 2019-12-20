<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->string('id')->primary('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->integer('civility')->unsigned();
            $table->string('street');
            $table->string('zipCode');
            $table->string('city');
            $table->string('complement')->nullable();
            $table->string('company')->nullable();
            $table->boolean('isDeleted')->nullable()->default(false);

            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->string('user_id');
            

            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('addresses');
    }
}
