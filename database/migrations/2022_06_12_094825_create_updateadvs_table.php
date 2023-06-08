<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateadvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('updateadvs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('adv_id');
            $table->string('name');
            $table->string('description');
            $table->double('price');
            $table->string('phone');
            $table->integer('place_id');
            $table->integer('cat_id');
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
        Schema::dropIfExists('updateadvs');
    }
}
