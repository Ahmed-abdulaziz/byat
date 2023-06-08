<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPaymnetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_paymnets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('img')->nullable();
            $table->integer('package_id');
            $table->integer('adv_id');
            $table->double('value')->nullable();
            $table->boolean('type');
            $table->integer('payment_method');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('user_paymnets');
    }
}
