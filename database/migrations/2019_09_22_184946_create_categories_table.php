<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('id')->primary('id');
            $table->string('name');
            $table->text('description');
            $table->string('mainImage')->nullable();
            $table->unsignedInteger('rank')->nullable();
            $table->boolean('isHidden')->nullable()->default(false);
            $table->boolean('isDeleted')->nullable()->default(false);

            $table->string('parent_id')->nullable()->index();
            
            $table->timestamps();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('categories');
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
