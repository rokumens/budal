<?php

namespace App\Http\Controllers;

use App\Models\Contacted;
use App\Models\Interested;
use App\Models\MasterNumbers;
use App\Models\Check;
use App\Models\Settings;
use App\Models\ConstantYesno;
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

class ContactedController extends Controller
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
    $connect_response = DB::table('connect_response')->get();
    $campaign_result = DB::table('campaign_result')->get();
    $next_action = DB::table('next_action')->get();
    $pageName = request()->segment(2);
    return view('numbers.contacted', compact('roles', 'connect_response', 'campaign_result', 'next_action', 'catGames', 'catWeb', 'pageName'));
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
    if(($user->can('list-contacted-all') && $user->can('list-contacted-own')) || $user->can('list-contacted-all')){
      if(!empty($startDateParam) && !empty($endDateParam)){
        $startDate = Carbon::create($startDateParam, 12, 0, 0)->startOfDay(); // time stamp akan jadi 00:00:00
        $endDate = Carbon::create($endDateParam, 12, 0, 0)->endofDay(); // time stamp akan jadi 23:59:59
        $data = Contacted::
                      leftJoin('master_numbers', 'contacted.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'contacted.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'contacted.category_game', '=', 'category_game.id')
                        ->select(
                          'contacted.id', 'contacted.created_at', 'contacted.master_numbers_id',
                          'master_numbers.phone', 'master_numbers.assign_to', 'master_numbers.contacted_by',
                          'category_web.name AS category_web', 
                          'category_game.name AS category_game')
                      ->whereBetween('contacted.created_at', [$startDate, $endDate]) //agar lebih akurat, pakai contacted_date
                      ->orderBy('contacted.id', 'desc');
      }else{
        $data = Contacted::
                        leftJoin('master_numbers', 'contacted.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'contacted.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'contacted.category_game', '=', 'category_game.id')
                        ->select(
                          'contacted.id', 'contacted.created_at', 'contacted.master_numbers_id',
                          'master_numbers.phone', 'master_numbers.assign_to', 'master_numbers.contacted_by',
                          'category_web.name AS category_web', 
                          'category_game.name AS category_game')
                        ->orderBy('contacted.id', 'desc');
      }
    }else{
      if(!empty($startDateParam) && !empty($endDateParam)){
        $startDate = Carbon::create($startDateParam, 12, 0, 0)->startOfDay(); // time stamp akan jadi 00:00:00
        $endDate = Carbon::create($endDateParam, 12, 0, 0)->endofDay(); // time stamp akan jadi 23:59:59
        $data = Contacted::
                      leftJoin('master_numbers', 'contacted.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'contacted.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'contacted.category_game', '=', 'category_game.id')
                        ->select(
                          'contacted.id', 'contacted.created_at', 'contacted.master_numbers_id',
                          'master_numbers.phone', 
                          'category_web.name AS category_web', 
                          'category_game.name AS category_game')
                      ->where('master_numbers.assign_to', '=', $user->id)
                      ->whereBetween('contacted.created_at', [$startDate, $endDate]) //agar lebih akurat, pakai contacted_date
                      ->orderBy('contacted.id', 'desc');
      }else{
        $data = Contacted::
                        leftJoin('master_numbers', 'contacted.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'contacted.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'contacted.category_game', '=', 'category_game.id')
                        ->select(
                          'contacted.id', 'contacted.created_at', 'contacted.master_numbers_id',
                          'master_numbers.phone', 
                          'category_web.name AS category_web', 
                          'category_game.name AS category_game')
                        ->where('master_numbers.assign_to', '=', $user->id)
                        ->orderBy('contacted.id', 'desc');
      }
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
                        if($user->can('view-contacted')){
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
                        if($user->can('edit-contacted')){
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
    $checkNumbers = Contacted::whereIn('id',explode(",",$idChecked))->get();
    $masterNumbersId = [];
    foreach($checkNumbers as $value){
      $masterNumbersId[] = $value->master_numbers_id;
    }
    // where attributes
    $attributes = [
      'is_assigned' => 1,
      'assign_to' => $assigntoId,
      'assigned_by' => Auth::id(),
      'assigned_date' => Carbon::now()->format('Y-m-d H:i:s'),
      'contacted_by' => $assigntoId,
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
    $contacted = Contacted::FindOrFail($id);
    $settings = Settings::FindOrFail(1);
    // contacted times from settings
    $contactedTimes = $settings->contacted_times;
    // contacted existing times
    $existingContactedTimes = $masterNumbers->contacted_times;
    // if connect response not active
    
    if($input['connectresponse'] != 1){

      // master numbers update
      $dataMaster = [
        'contacted_by' => $user->id,
        'note_contacted' => $input['note_contacted'],
        'connect_response_by_cs' => $input['connectresponse'],
        'campaign_result' => $input['campaignresult'],
        'contacted_times' => $existingContactedTimes+1,
      ];
      $masterNumbers->update($dataMaster);
      // get contacted times lastest update
      $updateExistingContactedTimes = $masterNumbers->contacted_times;

      if($updateExistingContactedTimes >= $contactedTimes){
        // move to check leader
        // insert to check table
        $dataCheck = [
          'master_numbers_id' => $input['master_numbers_id'],
          'category_web' => $masterNumbers->category_web,
          'category_game' => $masterNumbers->category_game,
        ];
        Check::insert($dataCheck);
        // delete number from contacted
        $contacted->forceDelete($id);
      }else{
        // master numbers update
        $dataMaster = [
          'contacted_by' => $user->id,
          'note_contacted' => $input['note_contacted'],
          'connect_response_by_cs' => $input['connectresponse'],
          'campaign_result' => $input['campaignresult'],
          'contacted_times' => $existingContactedTimes+1,
        ];
        $masterNumbers->update($dataMaster);
      }
    }else{// if number active
      // move data to interested
      if($input['campaignresult'] == 1){
        // make 1 if existing contacted times 0
        if($existingContactedTimes == 0){
          $existingContactedTimes = 1;
        }
        // master numbers update
        $dataMaster = [
          'contacted_by' => $user->id,
          'connect_response_by_cs' => $input['connectresponse'],
          'campaign_result' => $input['campaignresult'],
          'contacted_times' => $existingContactedTimes,
          'is_interested' => 1,
        ];
        $masterNumbers->update($dataMaster);
        // insert to interested table
        $dataInterested = [
          'master_numbers_id' => $input['master_numbers_id'],
          'category_web' => $masterNumbers->category_web,
          'category_game' => $masterNumbers->category_game,
        ];
        Interested::insert($dataInterested);
        // delete number from contacted
        $contacted->forceDelete($id);
      }else{
        // update master numbers
        $dataMaster = [
          'contacted_by' => $user->id,
          'note_contacted' => $input['note_contacted'],
          'connect_response_by_cs' => $input['connectresponse'],
          'campaign_result' => $input['campaignresult'],
          'contacted_times' => $existingContactedTimes+1,
        ];
        $masterNumbers->update($dataMaster);
        // move to check leader
        // insert to check leader table
        $dataInterested = [
          'master_numbers_id' => $input['master_numbers_id'],
          'category_web' => $masterNumbers->category_web,
          'category_game' => $masterNumbers->category_game,
        ];
        Check::insert($dataInterested);
        // delete number from contacted
        $contacted->forceDelete($id);
      }
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
      $results = Contacted::
                          leftJoin('master_numbers', 'contacted.master_numbers_id', '=', 'master_numbers.id')
                          ->leftJoin('users AS user_by', 'master_numbers.assigned_by', '=', 'user_by.id')
                          ->leftJoin('users AS user_to', 'master_numbers.assign_to', '=', 'user_to.id')
                          ->leftJoin('category_web', 'contacted.category_web', '=', 'category_web.id')
                          ->leftJoin('category_game', 'contacted.category_game', '=', 'category_game.id')
                          ->leftJoin('connect_response', 'master_numbers.connect_response_by_cs', 'connect_response.id')
                          ->leftJoin('campaign_result', 'master_numbers.campaign_result', 'campaign_result.id')
                          ->select(
                          'contacted.id', 'contacted.created_at', 'contacted.master_numbers_id',
                          'master_numbers.phone', 
                          'category_web.name AS category_web', 
                          'category_game.name AS category_game')
                          ->where('master_numbers.assign_to', '=', $user->id)
                          ->Where('master_numbers.phone', 'like', $searchTerm.'%')
                          ->orderBy('contacted.id', 'desc')->get();
    }else{
      $results = Contacted::
                          leftJoin('master_numbers', 'contacted.master_numbers_id', '=', 'master_numbers.id')
                          ->leftJoin('users AS user_by', 'master_numbers.assigned_by', '=', 'user_by.id')
                          ->leftJoin('users AS user_to', 'master_numbers.assign_to', '=', 'user_to.id')
                          ->leftJoin('category_web', 'contacted.category_web', '=', 'category_web.id')
                          ->leftJoin('category_game', 'contacted.category_game', '=', 'category_game.id')
                          ->leftJoin('connect_response', 'master_numbers.connect_response_by_cs', 'connect_response.id')
                          ->leftJoin('campaign_result', 'master_numbers.campaign_result', 'campaign_result.id')
                          ->select(
                          'contacted.id', 'contacted.created_at', 'contacted.master_numbers_id',
                          'master_numbers.phone', 
                          'category_web.name AS category_web', 
                          'category_game.name AS category_game')
                          ->Where('master_numbers.phone', 'like', $searchTerm.'%')
                          ->orderBy('contacted.id', 'desc')->get();
    }
    return response()->json([
      json_encode($results),
    ], Response::HTTP_OK);
  }
}
