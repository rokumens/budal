<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\Reassign;
use App\Models\Assigned;
use App\Models\MasterNumbers;
use App\Models\Settings;
use Illuminate\Http\Request;
use DB;
use Session;
use Auth;
use Illuminate\Http\Response;
use App\User;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\CategoryGame;
use App\Models\CategoryWeb;
use Illuminate\Support\Facades\Schema;

class CheckController extends Controller
{
  public function __construct()
  {
    $this->middleware(backpack_middleware());
  }
  
  public function index()
  {
    $user = backpack_user();
    $roles = $user->whereHas("roles", function($q){ $q->where("name", "user"); })->get();
    $catWeb = CategoryWeb::select('id', 'name')->get();
    $catGames = CategoryGame::select('id', 'name')->get();
    $constant = DB::table('constant_yesno')->get();
    $connect_response = DB::table('connect_response')->get();
    $campaign_result = DB::table('campaign_result')->get();
    $pageName = request()->segment(3);
    return view('numbers.leader.check', compact('connect_response', 'campaign_result', 'constant', 'roles', 'catGames', 'catWeb', 'pageName'));
  }

  function getdata(Request $request)
  {
    $input = $request->all();
    $user = backpack_user();
    \DB::connection()->disableQueryLog();
    if(!empty($input['startContactedDateVal'])){
      $startDateParam = $input['startContactedDateVal'];//Input::get('startContactedDateVal');
    }
    if(!empty($input['endContactedDateVal'])){
      $endDateParam = $input['endContactedDateVal'];//Input::get('endContactedDateVal');
    }

    if (!empty($startDateParam) && !empty($endDateParam)) {
        $startDate = Carbon::create($startDateParam, 12, 0, 0)->startOfDay(); // time stamp akan jadi 00:00:00
        $endDate = Carbon::create($endDateParam, 12, 0, 0)->endofDay(); // time stamp akan jadi 23:59:59
        $data = Check::
                      leftJoin('master_numbers', 'check.master_numbers_id', '=', 'master_numbers.id')
                      ->leftJoin('category_web', 'check.category_web', '=', 'category_web.id')
                      ->leftJoin('category_game', 'check.category_game', '=', 'category_game.id')
                      ->select(
                      'check.id', 'check.created_at', 'check.master_numbers_id',
                      'master_numbers.phone', 'master_numbers.assign_to', 'master_numbers.contacted_by',
                      'category_web.name AS category_web', 
                      'category_game.name AS category_game')
                      ->whereBetween('check.created_at', [$startDate, $endDate]) //agar lebih akurat, pakai contacted_date
                      ->orderBy('check.id', 'desc');
    }else{
      $data = Check::
                    leftJoin('master_numbers', 'check.master_numbers_id', '=', 'master_numbers.id')
                    ->leftJoin('category_web', 'check.category_web', '=', 'category_web.id')
                    ->leftJoin('category_game', 'check.category_game', '=', 'category_game.id')
                    ->select(
                    'check.id', 'check.created_at', 'check.master_numbers_id',
                    'master_numbers.phone', 'master_numbers.assign_to', 'master_numbers.contacted_by',
                    'category_web.name AS category_web', 
                    'category_game.name AS category_game')
                    ->orderBy('check.id', 'desc');
    }
    return Datatables::of($data)
                        ->setTotalRecords($data->count())
                        ->editColumn('created_at', function ($query) {
                            return $query->created_at ? with(new Carbon($query->created_at))->format('d F Y') : '';
                        })
                        ->addColumn('is_cs_exist', function($query){
                          if($query->contacted_by == NULL){
                            $user = User::find($query->assign_to);
                          }else{
                            $user = User::find($query->contacted_by);
                          }
                          if($user != NULL || $user){
                            return '';
                          }else{
                            return '<span class="badge badge-danger">Must change CS</span>';
                          }
                        })
                        ->addColumn('button', function($query) use($user){
                          $button = '';
                          if($user->can('view-check')){
                            if($query->contacted_by == NULL){
                              $userId = User::find($query->assign_to);
                            }else{
                              $userId = User::find($query->contacted_by);
                            }
                            if($userId != NULL || $userId){
                              $button .= '<a href="#" class="btn btn-sm btn-success viewModalBtn mr-2" data-toggle="modal" data-id="'.$query->id.'" data-master_numbers_id="'.$query->master_numbers_id.'">View</a>';
                            }else{
                              $button .= '<a href="#" class="btn btn-sm btn-success viewModalBtn mr-2" data-toggle="modal" data-is_cs_exist="false" data-id="'.$query->id.'" data-master_numbers_id="'.$query->master_numbers_id.'">View</a>';
                            }
                          }
                          if($user->can('edit-check')){
                            $button .= '<a href="#" class="btn btn-sm btn-info editModalBtn" data-toggle="modal" data-id="'.$query->id.'" data-master_numbers_id="'.$query->master_numbers_id.'">Edit</a>';
                          }
                          return $button;
                        })
                        ->rawColumns(['button', 'is_cs_exist'])
                        ->make(true);
  }

  public function assignto(Request $request)
  {
    $idChecked = $request->ids;
    $assigntoId = $request->assignto;
    // 7381 jazz - 24 feb 2020 15:36
    $checkNumbers = Check::whereIn('id',explode(",",$idChecked))->get();
    $masterNumbersId = [];
    foreach($checkNumbers as $value){
      $masterNumbersId[] = $value->master_numbers_id;
    }
    // where attributes
    $attributes = [
      'is_assigned' => 1,
      'assign_to' => $assigntoId,
      'contacted_by' => $assigntoId,
      'assigned_by' => Auth::id(),
      'assigned_date' => Carbon::now()->format('Y-m-d H:i:s'),
    ];
    // update master numbers table with above attribute
    \DB::table('master_numbers')->whereIn('id', $masterNumbersId)->update($attributes);
    Session::put('success', 'Successfully change CS.');
    return response()->json(['status'=>true,'message'=>""]);
  }

  public function update(Request $request, $id)
  {
    $user = Auth::user();
    // get all request into array
    $input = $request->all();
    //update from the modal
    $masterNumbers = MasterNumbers::FindOrFail($input['master_numbers_id']);
    $check = Check::FindOrFail($id);
    // get settings data
    $settings = Settings::findOrFail(1);
    // get existing assign times by id master numbers
    $currentAssignedTimesMaster = $masterNumbers->assigned_times;
    $nextAssignedTimesMaster = $masterNumbers->assigned_times + 1;
    // get assined times now from settings
    $existingTimesNowSettings = $settings->assigned_times_now;
    if($currentAssignedTimesMaster >= $existingTimesNowSettings){
      // prevant error when column not found
      if($currentAssignedTimesMaster!=0 && !Schema::hasColumn('master_numbers', 'check_'.$currentAssignedTimesMaster.'_1')){
        if($user->isAdmin()){
          Session::put('errorNoFade', 'Error found! Assigned times setting error, change setting <a href="/settings" style="color:#0079ff;">here</a>.');
        }else{
          Session::put('errorNoFade', 'Error found! Assigned times setting error, contact admin for setting asigned times change.');
        }
        return back();
      }
      // move data to reassign
      // master numbers update
      if($currentAssignedTimesMaster == 0){
        $dataMaster = [
            'check_' . $nextAssignedTimesMaster . '_1' => $user->id, // check by leader
            'check_' . $nextAssignedTimesMaster . '_2' => Carbon::now()->format('Y-m-d H:i:s'), // check date by leader
            'check_' . $nextAssignedTimesMaster . '_3' => $input['connectresponse'], // connect response by leader
            'check_' . $nextAssignedTimesMaster . '_4' => $input['note_check'], // note by leader
        ];
      }else{
        $dataMaster = [
          'check_'.$currentAssignedTimesMaster.'_1' => $user->id, // check by leader
          'check_'.$currentAssignedTimesMaster.'_2' => Carbon::now()->format('Y-m-d H:i:s'), // check date by leader
          'check_'.$currentAssignedTimesMaster.'_3' => $input['connectresponse'], // connect response by leader
          'check_'.$currentAssignedTimesMaster.'_4' => $input['note_check'], // note by leader
        ];
      }
      
      $masterNumbers->update($dataMaster);
      // insert to reassign table
      $dataReassign = [
        'master_numbers_id' => $input['master_numbers_id'],
        'category_web' => $masterNumbers->category_web,
        'category_game' => $masterNumbers->category_game,
      ];
      Reassign::insert($dataReassign);
      // delete number from check
      $check->forceDelete($id);
    }else{
      // prevant error when column not found
      if($currentAssignedTimesMaster!=0 && !Schema::hasColumn('master_numbers', 'check_'.$currentAssignedTimesMaster.'_1')){
        if($user->isAdmin()){
          Session::put('errorNoFade', 'Error found! Assigned times setting error, change setting <a href="/settings" style="color:#0079ff;">here</a>.');
        }else{
          Session::put('errorNoFade', 'Error found! Assigned times setting error, contact admin for setting asigned times change.');
        }
        return back();
      }
      // master numbers update
      if($currentAssignedTimesMaster == 0){
        $dataMaster = [
          'connect_response_by_cs' => null,
          'campaign_result' => null,
          'note_contacted' => null,
          'is_assigned' => 1,
          'is_contacted' => 0,
          'contacted_date' => null,
          'contacted_times' => 0,
          'contacted_by' => null,
          'check_' . $nextAssignedTimesMaster . '_1' => $user->id, // check by leader
          'check_' . $nextAssignedTimesMaster . '_2' => Carbon::now()->format('Y-m-d H:i:s'), // check date by leader
          'check_' . $nextAssignedTimesMaster . '_3' => $input['connectresponse'], // connect response by leader
          'check_' . $nextAssignedTimesMaster . '_4' => $input['note_check'], // note by leader
          'assigned_times' => $nextAssignedTimesMaster,
        ];
      }else{
        $dataMaster = [
          'connect_response_by_cs' => null,
          'campaign_result' => null,
          'note_contacted' => null,
          'is_assigned' => 1,
          'is_contacted' => 0,
          'contacted_date' => null,
          'contacted_times' => 0,
          'contacted_by' => null,
          'check_' . $currentAssignedTimesMaster . '_1' => $user->id, // check by leader
          'check_' . $currentAssignedTimesMaster . '_2' => Carbon::now()->format('Y-m-d H:i:s'), // check date by leader
          'check_' . $currentAssignedTimesMaster . '_3' => $input['connectresponse'], // connect response by leader
          'check_' . $currentAssignedTimesMaster . '_4' => $input['note_check'], // note by leader
          'assigned_times' => $nextAssignedTimesMaster,
      ];

      }
      $masterNumbers->update($dataMaster);
      // insert to assign table
      $dataAssign = [
        'master_numbers_id' => $input['master_numbers_id'],
        'category_web' => $masterNumbers->category_web,
        'category_game' => $masterNumbers->category_game,
      ];
      Assigned::insert($dataAssign);
      // delete number from check
      $check->forceDelete($id);
    }

    $result = 0;
    if ($result == 0) {
      Session::put('success', 'Successfully updated.');
      return back();
    } else {
      Session::put('error', 'Error found! Please try again.');
      return back();
    }
  }

  public function search(Request $request)
  {
    $user = Auth::user();
    // get all request to array
    $input = $request->all();
    $searchTerm = $input['numbers_search_box'];
    if ($user->isCs()) {
      $results = Check::
                      leftJoin('master_numbers', 'check.master_numbers_id', '=', 'master_numbers.id')
                      ->leftJoin('category_web', 'check.category_web', '=', 'category_web.id')
                      ->leftJoin('category_game', 'check.category_game', '=', 'category_game.id')
                      ->select(
                      'check.id', 'check.created_at', 'check.master_numbers_id',
                      'master_numbers.phone',
                      'category_web.name AS category_web', 
                      'category_game.name AS category_game')
                      ->where('master_numbers.contacted_by', '=', $user->id)
                      ->Where('master_numbers.phone', 'like', $searchTerm.'%')
                      ->orderBy('check.id', 'desc')->get();
    }else{
      $results = Check::
                      leftJoin('master_numbers', 'check.master_numbers_id', '=', 'master_numbers.id')
                      ->leftJoin('category_web', 'check.category_web', '=', 'category_web.id')
                      ->leftJoin('category_game', 'check.category_game', '=', 'category_game.id')
                      ->select(
                      'check.id', 'check.created_at', 'check.master_numbers_id',
                      'master_numbers.phone',
                      'category_web.name AS category_web', 
                      'category_game.name AS category_game')
                      ->Where('master_numbers.phone', 'like', $searchTerm.'%')
                      ->orderBy('check.id', 'desc')->get();
    }
    return response()->json([
      json_encode($results),
    ], Response::HTTP_OK);
  }
}
