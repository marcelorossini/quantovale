<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
  protected $table = 'maintenance';
  protected $fillable = [
      'name','auxliar','completed','date','shared'
  ];
  public $timestamps = false;
}
