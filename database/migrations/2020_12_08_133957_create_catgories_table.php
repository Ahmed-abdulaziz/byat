<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatgoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catgories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('img')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('catgories')->onDelete('cascade');
            $table->boolean('active')->default(1);
            $table->boolean('editable')->default(1);
             $table->integer('examination_image')->default(0)->comment('0-not required 1-required');
            $table->timestamps();
            
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catgories');
    }
}
