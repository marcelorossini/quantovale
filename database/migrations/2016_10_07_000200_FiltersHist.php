<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FiltersHist extends Migration
{
    public function up()
    {
        Schema::create('filters_hist', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_filter')->unsigned();
            //$table->foreign('id_category')->references('id')->on('categories');
            $table->double('percent');
            $table->date('date');
        });
    }

    public function down()
    {
        Schema::drop('filters_hist');
    }
}
