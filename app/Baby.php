<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baby extends Model
{

  protected $dates = ['birthday'];

  protected $fillable = [
    'id',
    'parent_id',
    'name',
    'birthday',
    'sex',
    'created_at',
    'updated_at'
  ];

  public function getBabySex() {
    switch($this->sex) {
      case 'M': return 'Masculino'; break;
      case 'F': return 'Feminino'; break;
      default: return 'Outro'; break;
    }
  }

  public function getBabyBirthday() {
    switch($this->sex) {
      case 'M': return 'Nascido em'; break;
      case 'F': return 'Nascida em'; break;
      default: return 'Nascido(a) em'; break;
    }
  }

}