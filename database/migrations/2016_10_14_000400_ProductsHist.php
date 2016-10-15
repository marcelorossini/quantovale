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
            $table->integer('id_product')->unsigned();
            $table->foreign('id_product')->references('id')->on('products');
            $table->integer('id_provider')->unsigned();
            $table->foreign('id_provider')->references('id')->on('providers');
            $table->integer('provider_cod')->unsigned();
            $table->date('date');
            $table->double('price_min', 15, 8);
            $table->double('price_max', 15, 8);
        });
    }

    public function down()
    {
        Schema::drop('products_hist');
    }
}
