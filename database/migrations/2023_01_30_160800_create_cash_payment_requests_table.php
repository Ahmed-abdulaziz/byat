<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashPaymentRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_payment_requests', function (Blueprint $table) {
                    $table->increments('id');
                    $table->integer('user_id')->unsigned();
                    $table->integer('product_id');
                    $table->integer('adv_id')->nullable();
                    $table->integer('type');
                    $table->double('money');
                    $table->integer('status')->default(0);
                    $table->timestamps();
                
                  $table->foreign('user_id')->references('id')->on('app_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_payment_requests');
    }
}
