<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
  protected $table = 'manufacturers';
  protected $fillable = [
      'name','id_provider','provider_cod'
  ];
  public $timestamps = false;
}
