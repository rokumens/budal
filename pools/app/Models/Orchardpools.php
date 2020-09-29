<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orchardpools extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'orchardpools_winner';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'number',
    'show',
    'draw_no',
  ];
}
