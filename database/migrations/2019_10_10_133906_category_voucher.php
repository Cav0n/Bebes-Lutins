<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoryVoucher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_voucher', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category_id');
            $table->string('voucher_id');

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('voucher_id')->references('id')->on('vouchers');

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
        Schema::dropIfExists('category_voucher');
    }
}
