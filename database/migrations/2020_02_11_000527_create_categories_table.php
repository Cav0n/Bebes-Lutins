<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->text('description');
            $table->integer('rank')->default(0);
            $table->boolean('isHidden')->default(0);
            $table->boolean('isDeleted')->default(0);
            $table->string('parentId')->nullable();

            $table->timestamps();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parentId')
                    ->references('id')->on('categories')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
