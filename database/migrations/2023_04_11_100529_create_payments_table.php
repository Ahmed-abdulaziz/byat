<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('PaymentID');
            $table->string('TranID');
            $table->string('TrackID');
            $table->string('OrderID');
            $table->double('price');
            $table->integer('user_id');
            $table->integer('package_id')->nullable();
            $table->integer('adv_id')->nullable();
            $table->integer('auction_id')->nullable()->comment('deposit auction');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('payments');
    }
}
