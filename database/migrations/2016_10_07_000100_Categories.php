<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Categories extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->integer('id');
            //$table->primary('id');
            $table->string('name');
        });
    }

    public function down()
    {
        Schema::drop('categories');
    }
}