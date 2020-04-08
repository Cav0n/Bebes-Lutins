<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsI18nsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_i18ns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('setting_id')->unsigned();
            $table->string('locale');
            $table->string('title');
            $table->text('help')->nullable();

            $table->foreign('setting_id')
                    ->references('id')->on('settings')
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
        Schema::dropIfExists('settings_i18ns');
    }
}
