<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndexMasterNumbers extends Model
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
    public $timestamp = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'index_master_numbers';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'id',
      'uploaded_by',
      'created_at'
    ];
}
