<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWinnerMonthlyWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('winner__monthly_withdrawals', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->integer('monthly_withdrawals_id')->unsigned();
                $table->timestamps();
                
                
                $table->foreign('user_id')->references('id')->on('app_users')->onDelete('cascade');
                $table->foreign('monthly_withdrawals_id')->references('id')->on('monthly_withdrawals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('winner__monthly_withdrawals');
    }
}
