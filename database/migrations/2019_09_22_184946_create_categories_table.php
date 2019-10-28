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

            // The previous `nestedSet` blueprint helper is equivalent to
            // the following column/field declarations:
            //
            $table->string('parent_id')->nullable();
            $table->integer('left')->unsigned()->nullable()->index();
            $table->integer('right')->unsgined()->nullable()->index();
            $table->integer('depth')->unsigned()->nullable()->index();
            //
            // Feel free to modify at your own will but note that all columns
            // *must be present* and initialized on the model accordingly.
            
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
