<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryItemProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_item_products', function (Blueprint $table) {
           $table->increments('id');
            $table->integer('category_item_id')->unsigned();;
            $table->integer('category_item_component_id')->nullable()->unsigned();
            $table->string('text')->nullable();
            $table->integer('product_id');
            $table->integer('type')->comment('0-adv  1-auction');
            $table->timestamps();
            
            $table->foreign('category_item_id')->references('id')->on('category_items')->onDelete('cascade');
            $table->foreign('category_item_component_id')->references('id')->on('category_item_components')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_item_products');
    }
}
