<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
  protected $table = 'categories_filters';
  protected $fillable = [
      'id_category','type','name','order','default'
  ];
  public $timestamps = false;
}
