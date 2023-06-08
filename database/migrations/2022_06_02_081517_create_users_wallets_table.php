<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_wallets', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('user_id');
        $table->integer('auction_id')->nullable();
        $table->double('money');
        $table->text('comment');
        $table->text('code')->nullable();;
        $table->double('amount')->nullable();
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
        Schema::dropIfExists('users_wallets');
    }
}
