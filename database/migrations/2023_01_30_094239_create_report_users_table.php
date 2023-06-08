<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('section')->comment('1-adv  2-auction');
            $table->integer('user_id')->unsigned();
            $table->integer('report_id')->unsigned();
            $table->string('report_text')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('app_users')->onDelete('cascade');
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_users');
    }
}
