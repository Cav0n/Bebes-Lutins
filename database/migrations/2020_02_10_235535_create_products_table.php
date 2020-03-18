<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('id')->primary();
            $table->string('reference')->nullable();
            $table->string('name');
            $table->text('description');
            $table->double('price');
            $table->double('promoPrice')->nullable();
            $table->integer('stock')->default(0);
            $table->boolean('isHighlighted')->default(0);
            $table->boolean('isHidden')->default(0);
            $table->boolean('isDeleted')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
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
