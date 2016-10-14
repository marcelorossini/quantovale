<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
           $table->increments('id');
           $table->string('name');
           $table->string('short_name');
           $table->integer('id_category')->unsigned();
           $table->foreign('id_category')->references('id')->on('categories');
        });
    }

    public function down()
    {
        Schema::drop('products');
    }
}
