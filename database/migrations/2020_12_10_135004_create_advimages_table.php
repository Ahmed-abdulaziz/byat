<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advimages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('adv_id')->unsigned();
            $table->foreign('adv_id')->references('id')->on('advertisments')->onDelete('cascade');
            $table->string('img');
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
        Schema::dropIfExists('advimages');
    }
}
