<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriesXProviders extends Migration
{
    public function up()
    {
        Schema::create('categories_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_category')->unsigned();
            $table->foreign('id_category')->references('id')->on('categories');
            $table->integer('id_provider')->unsigned();
            $table->foreign('id_provider')->references('id')->on('providers');
        });
    }

    public function down()
    {
        Schema::drop('categories_providers');
    }
}
