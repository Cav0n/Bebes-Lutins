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
            $table->string('id')->primary('id');
            $table->decimal('shippingPrice',10,2)->unsigned();
            $table->decimal('productsPrice', 10,2)->unsigned();
            $table->integer('paymentMethod')->unsigned();
            $table->text('customerMessage')->nullable();
            $table->integer('status')->default(0);
            $table->boolean('isCanceled')->default(0);

            $table->string('user_id');
            $table->string('voucher_id')->nullable();
            $table->string('shipping_address_id');
            $table->string('billing_address_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('voucher_id')->references('id')->on('vouchers');
            $table->foreign('shipping_address_id')->references('id')->on('addresses');
            $table->foreign('billing_address_id')->references('id')->on('addresses');

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
