<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
  protected $table = 'providers';
  protected $fillable = [
      'name'
  ];
  public $timestamps = false;
}
