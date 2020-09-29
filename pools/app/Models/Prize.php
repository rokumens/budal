<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prize';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image',
    ];
}
