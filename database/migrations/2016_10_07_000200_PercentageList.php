<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PercentageList extends Migration
{
    public function up()
    {
        Schema::create('percentage_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_category')->nullable();
            $table->integer('id_product')->nullable();
            $table->integer('id_filter')->nullable();
            //$table->foreign('id_category')->references('id')->on('categories');
            $table->double('percent');
            $table->date('date');
        });
    }

    public function down()
    {
        Schema::drop('percentage_list');
    }
}
