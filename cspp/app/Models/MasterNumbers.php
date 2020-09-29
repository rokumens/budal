<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;// nonactive cause the view can show propoerly

class MasterNumbers extends Model
{
    // use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = [// nonactive cause the view can show propoerly
    //     'deleted_at',
    // ];

    // protected $dates = ['deleted_at'];// nonactive cause the view can show propoerly

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'master_numbers';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
		*/
		protected $guarded = ['id'];
    // protected $fillable = [
		// 	'id',
		// 	'phone',
		// 	'email',
		// 	'connect_response_by_cs',
		// 	'campaign_result',
		// 	'next_action',
		// 	'note_contacted',
		// 	'is_assigned',
		// 	'is_contacted',
		// 	'assign_to',
		// 	'assigned_by',
		// 	'assigned_date',
		// 	'contacted_date',
		// 	'category_web',
		// 	'category_game',
		// 	'uploaded_at',
		// 	'updated_at',
		// 	'index_id',
		// 	'contacted_times',
		// 	'contacted_by',
		// 	'is_interested',
		// 	'is_registered',
		// 	'registered_date',
		// 	'registered_by',
		// 	'note_registered',
		// 	'is_deposit',
		// 	'check_1_by_leader',
		// 	'check_1_date_by_leader',
		// 	'connect_response_1_by_leader',
		// 	'note_check_1_by_leader',
		// 	'check_2_by_leader',
		// 	'check_2_date_by_leader',
		// 	'connect_response_2_by_leader',
		// 	'note_check_2_by_leader',
		// 	'check_3_by_leader',
		// 	'check_3_date_by_leader',
		// 	'connect_response_3_by_leader',
		// 	'note_check_3_by_leader',
		// 	'assigned_times',
    // ];
}
