<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('package_id');
             $table->integer('adv_id')->nullable();
              $table->integer('bank_id')->nullable();
            $table->integer('type')->comment("1- Advertimnets .  2- Auctions   . 3- star");
            $table->string('image')->nullable();
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
        Schema::dropIfExists('packages_subscriptions');
    }
}
