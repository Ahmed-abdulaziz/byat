<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceRecoveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_recoveries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank');
            $table->string('user_name');
            $table->string('user_phone');
            $table->string('account_number');
            $table->string('iban_number');
            $table->integer('status')->default("0");
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
        Schema::dropIfExists('balance_recoveries');
    }
}
