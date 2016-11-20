<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
  protected $table = 'inputs';
  protected $fillable = [
      'text','id_user'
  ];
  public $timestamps = false;
}
