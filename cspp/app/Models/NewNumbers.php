<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewNumbers extends Model
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
    protected $table = 'new_numbers';
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