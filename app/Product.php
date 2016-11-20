<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $table = 'products';
  protected $fillable = [
      'name','short_name','id_category','provider_cod'
  ];
  public $timestamps = false;
}
