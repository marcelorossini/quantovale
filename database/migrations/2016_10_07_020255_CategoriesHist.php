<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriesHist extends Migration
{
    public function up()
    {
        Schema::create('categories_hist', function (Blueprint $table) {
            $table->string('id_category')->index();
            $table->double('percent')->index();
            $table->date('date');
        });
    }

    public function down()
    {
        Schema::drop('categories_hist');
    }
}
