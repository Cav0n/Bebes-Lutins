<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('discountType');
            $table->double('discountValue')->nullable();
            $table->timestamp('minValidDate')->useCurrent();
            $table->timestamp('maxValidDate')->nullable();
            $table->double('minCartPrice')->nullable();
            $table->integer('maxUsage')->nullable();
            $table->boolean('isActive')->default(0);

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
        Schema::dropIfExists('promo_codes');
    }
}
