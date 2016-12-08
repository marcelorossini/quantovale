<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Maintenance extends Migration
{
    public function up()
    {
      Schema::create('maintenance', function (Blueprint $table) {
          $table->increments('id');
          $table->text('name');
          $table->integer('auxliar')->unsigned()->nullable();
          $table->boolean('completed')->default(false);
          $table->date('date');
      });
    }

    public function down()
    {
        Schema::drop('maintenance');
    }
}
