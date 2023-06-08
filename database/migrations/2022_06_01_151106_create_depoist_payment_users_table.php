<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepoistPaymentUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depoist_payment_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_id");
            $table->integer("auction_id");
            $table->double("amount");
            $table->integer("status")->default("0");
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
        Schema::dropIfExists('depoist_payment_users');
    }
}
