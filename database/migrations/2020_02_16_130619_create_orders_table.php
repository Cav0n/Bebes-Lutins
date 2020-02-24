<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('status')->default('WAIT_PAYMENT');
            $table->string('paymentMethod');
            $table->double('shippingCosts')->default(0.0);
            $table->string('email');
            $table->string('phone')->nullable();
            $table->bigInteger('billing_address_id')->unsigned();
            $table->bigInteger('shipping_address_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('voucher_id')->nullable();

            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');

            $table->foreign('billing_address_id')
                    ->references('id')->on('addresses')
                    ->onDelete('cascade');

            $table->foreign('shipping_address_id')
                    ->references('id')->on('addresses')
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
        Schema::dropIfExists('orders');
    }
}
