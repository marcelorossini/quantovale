<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Inputs extends Migration
{
    public function up()
    {
        Schema::create('inputs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');
            $table->integer('id_user')->unsigned()->nullable();
            $table->dateTime('created_at');
        });
    }

    public function down()
    {
        Schema::drop('inputs');
    }
}
