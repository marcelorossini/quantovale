<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $table = 'categories';
  protected $fillable = [
      'name','id_parent','id_provider','provider_cod'
  ];
  public $timestamps = false;
}
