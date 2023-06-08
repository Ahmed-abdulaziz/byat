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
                $table->integer('user_id')->unsigned();
                $table->string('name');
                $table->string('description');
                $table->integer('cat_id');
                $table->integer('place_id');
                $table->string('phone');
                $table->integer('star')->default(0);
                $table->date('end_star')->nullable();
                $table->string('examination_certificate');
                $table->double('price')->nullable();
                $table->boolean('status')->default(0);
                $table->integer('views')->default(0);
                $table->timestamps();
                $table->softDeletes();
                
                $table->foreign('user_id')->references('id')->on('app_users')->onDelete('cascade');

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
