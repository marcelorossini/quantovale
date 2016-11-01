<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductHist extends Model
{
  protected $table = 'products_hist';
  protected $fillable = [
      'id_product','date','price_min','price_max'
  ];
  public $timestamps = false;
}
