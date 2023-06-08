<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryItemInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_item_inputs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title_ar');
                $table->string('title_en');
                $table->string('placeholder_ar')->nullable();
                $table->string('placeholder_en')->nullable();
                $table->string('unit_ar')->nullable();
                $table->string('unit_en')->nullable();
                $table->integer('category_item_id')->unsigned();
                $table->timestamps();
                
                
                $table->foreign('category_item_id')->references('id')->on('category_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_item_inputs');
    }
}
