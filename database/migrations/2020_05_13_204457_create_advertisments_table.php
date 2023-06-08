<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertismentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('description');
            $table->double('price');
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->integer('place_id');
            $table->integer('cat_id');
            $table->date('end_star');
            $table->string('examination_certificate')->nullable();
            $table->integer('star')->default(0);
            $table->integer('status')->default(0);
            $table->integer('views')->default(0);
            $table->date('end_date');
            $table->date('end_date_in_profile');
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
        Schema::dropIfExists('advertisments');
    }
}
