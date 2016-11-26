<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
  protected $table = 'results';
  protected $fillable = [
      'result','id_product','id_user','save'
  ];
  public $timestamps = false;
}
