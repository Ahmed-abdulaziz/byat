<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('description');
            $table->double('amount_open');
            $table->double('maximum_amount');
            $table->double('deposit_amount');
            $table->integer('day');
            $table->integer('hours');
            $table->integer('place_id');
            $table->integer('cat_id');
            $table->integer("owner_id")->default("0");
            $table->timestamp('end_date')->nullable();
            $table->date('end_date_in_app')->nullable();
            $table->date('end_date_in_profile')->nullable();
             $table->string('examination_certificate')->nullable();
            $table->integer('status')->default("0");
            $table->integer('show_status')->default("0");
            $table->integer('views')->default(0);
             $table->integer('repost')->default(0);
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
        Schema::dropIfExists('auctions');
    }
}
