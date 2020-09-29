<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interested extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = [
    //     'deleted_at',
    // ];

    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interested';
    public $timestamps = true;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'master_numbers_id',
      'category_web',
      'category_game',
      'created_at'
    ];
}
