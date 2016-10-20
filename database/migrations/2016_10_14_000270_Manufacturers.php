<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Manufacturers extends Migration
{
    public function up()
    {
        Schema::create('manufacturers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('id_provider')->unsigned();
            $table->integer('provider_category')->unsigned();
            $table->integer('provider_manufacture')->unsigned();
            //$table->foreign('id_provider')->references('id')->on('providers');
        });
    }

    public function down()
    {
        Schema::drop('manufacturers');
    }
}
