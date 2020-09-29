<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'settings';
  public $timestamps = true;
  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'contacted_times',
    'assigned_times_previous',
    'assigned_times_now',
    'assigned_times_max',
  ];
}
