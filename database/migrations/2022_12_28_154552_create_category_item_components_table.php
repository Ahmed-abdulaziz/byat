<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryItemComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_item_components', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->nullable();
            $table->string('name_ar');
            $table->string('name_en');
            $table->integer('category_item_id')->unsigned();
            $table->integer('parent_category_components')->unsigned()->nullable();
            $table->timestamps();
            
            $table->foreign('category_item_id')->references('id')->on('category_items')->onDelete('cascade');
            $table->foreign('parent_category_components')->references('id')->on('category_item_components')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_item_components');
    }
}
