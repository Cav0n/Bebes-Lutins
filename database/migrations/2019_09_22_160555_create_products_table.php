<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('id')->primary('id');
            $table->string('reference')->nullable()->default(null);
            $table->string('name');
            $table->text('description');
            $table->string('mainImage')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedDecimal('price', 10, 2);
            $table->boolean('isHighlighted')->default(false);
            $table->boolean('isHidden')->default(false);
            $table->boolean('isDeleted')->default(false);
            $table->unsignedBigInteger('reviewsCount')->default(0);
            $table->unsignedBigInteger('reviewsStars')->default(0);

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
        Schema::dropIfExists('products');
    }
}
