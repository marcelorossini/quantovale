<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriesHist extends Migration
{
    public function up()
    {
        Schema::create('categories_hist', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_category')->unsigned();
            $table->foreign('id_category')->references('id')->on('categories');
            $table->double('percent');
            $table->date('date');
        });
    }

    public function down()
    {
        Schema::drop('categories_hist');
    }
}
