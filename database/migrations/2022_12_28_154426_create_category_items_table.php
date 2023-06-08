<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->integer('cat_id')->unsigned();
            $table->integer('type')->comment('1- single select . 2- mutli select . 3-text');
            $table->integer('can_skip')->default(0);
            $table->integer('componant_have_image')->default(0);
            $table->integer('check_fom')->default(1);
            $table->integer('parent_category_items')->unsigned()->nullable();
            $table->timestamps();
            
            $table->foreign('cat_id')->references('id')->on('catgories')->onDelete('cascade');
            $table->foreign('parent_category_items')->references('id')->on('category_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_items');
    }
}
