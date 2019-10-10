<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->string('id')->primary('id');
            $table->string('code');
            $table->decimal('discountValue',10,2)->unsigned()->nullable();
            $table->integer('discountType')->unsigned();
            $table->dateTime('dateFirst');
            $table->dateTime('dateLast');
            $table->decimal('minimalPrice',10,2)->unsigned()->nullable();
            $table->boolean('isDeleted')->default(false);

            $table->boolean('certainProducts')->nullable();
            $table->boolean('allProducts')->nullable();

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
        Schema::dropIfExists('vouchers');
    }
}
