<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{

  protected $fillable = [
    'id',
    'baby_id',
    'type',
    'description',
    'date',
    'created_at',
    'updated_at'
  ];

}