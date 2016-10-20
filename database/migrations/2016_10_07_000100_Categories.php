<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Categories extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            //$table->primary('id');
            $table->string('name');
            $table->integer('id_parent');
            $table->integer('id_provider')->unsigned();
            $table->integer('provider_category')->unsigned();
        });
    }

    public function down()
    {
        Schema::drop('categories');
    }
}
