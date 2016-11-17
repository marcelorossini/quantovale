<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriesFilters extends Migration
{
    public function up()
    {
      Schema::create('categories_filters', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_category')->unsigned();
          //$table->foreign('id_category')->references('id')->on('categories');
          $table->string('type');
          $table->string('name');
          $table->integer('order')->unsigned();
      });
    }

    public function down()
    {
        Schema::drop('categories_filters');
    }
}
