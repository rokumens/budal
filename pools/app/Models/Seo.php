<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'orchardpools_seo';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'menu_name',
    'title',
    'keyword',
    'description',
    'canonical',
    'url',
    'property',
    'image',
  ];
}
