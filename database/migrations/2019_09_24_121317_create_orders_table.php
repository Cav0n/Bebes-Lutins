<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('shippingPrice',10,2)->unsigned();
            $table->decimal('productsPrice', 10,2)->unsigned();
            $table->integer('paymentMethod')->unsigned();
            $table->text('customerMessage')->nullable();
            $table->integer('status')->default(0);
            $table->boolean('isCanceled')->default(0);

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('voucher_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('orders');
    }
}
