<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_settings', function (Blueprint $table) {
                $table->increments('id');
                $table->text('usingplicy_ar')->nullable();
                $table->text('usingplicy_en')->nullable();
                $table->text('aboutapp_ar')->nullable();
                $table->text('aboutapp_en')->nullable();
                $table->text('facebook')->nullable();
                $table->text('twwiter')->nullable();
                $table->text('instgram')->nullable();
                $table->text('youtube')->nullable();
                $table->text('whatsapp')->nullable();
                $table->text('email')->nullable();
                $table->integer('maximum_duration_auction')->default(0);
                $table->text('phone')->nullable();
                $table->integer('ad_duration')->default(0);
                $table->integer('ad_duration_profile')->default(0);
                $table->integer('auction_duration')->default(0);
                $table->integer('auction_duration_profile')->default(0);
                $table->text('free_adv')->nullable();
                $table->text('free_auctions')->nullable();
                $table->text('adv_value')->nullable();
                $table->text('adv_notfication')->nullable();
                $table->text('after_adv_ar')->nullable();
                $table->text('after_adv_en')->nullable();
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
        Schema::dropIfExists('app_settings');
    }
}
