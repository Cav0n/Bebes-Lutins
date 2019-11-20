<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id')->primary('id');
            $table->string('email')->unique();
            $table->string('password');

            $table->string('firstname');
            $table->string('lastname');
            $table->boolean('wantNewsletter')->default(1);
            $table->string('phone', 10)->nullable();
            $table->date('birthdate')->nullable();

            $table->boolean('isAdmin')->default(0);
            $table->integer('privileges')->unsigned()->default(0);

            $table->string('resetCode')->nullable();
            $table->rememberToken();
            
            $table->timestamps();
            $table->timestamp('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
