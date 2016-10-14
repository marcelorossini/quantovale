<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsHist extends Migration
{
    public function up()
    {
        Schema::create('products_hist', function (Blueprint $table) {
            $table->increments('id');
          
        });
    }

    public function down()
    {
        Schema::drop('products_hist');
    }
}
