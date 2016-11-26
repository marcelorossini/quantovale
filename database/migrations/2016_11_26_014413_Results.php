<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Results extends Migration
{
    public function up()
    {
      Schema::create('results', function (Blueprint $table) {
          $table->increments('id');
          $table->text('result');
          $table->integer('id_product')->unsigned();
          $table->integer('id_user')->unsigned()->nullable();
          $table->boolean('save')->default(false);
          $table->dateTime('created_at');
      });
    }

    public function down()
    {
        Schema::drop('results');
    }
}
