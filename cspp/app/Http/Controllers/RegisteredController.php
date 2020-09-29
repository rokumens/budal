<?php

namespace App\Http\Controllers;

use App\Models\Registered;
use App\Models\MasterNumbers;
use App\Models\Players;
use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Http\Response;
use App\User;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\CategoryGame;
use App\Models\CategoryWeb;

class RegisteredController extends Controller
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
    $nextAction = DB::table('next_action')->get();
    $pageName = request()->segment(3);
    return view('numbers.followup.registered', compact('nextAction', 'constant', 'roles', 'catGames', 'catWeb', 'pageName'));
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
    if(($user->can('list-registered-all') && $user->can('list-registered-own')) || $user->can('list-registered-all')){
      if(!empty($startDateParam) && !empty($endDateParam)){
        $startDate = Carbon::create($startDateParam, 12, 0, 0)->startOfDay(); // time stamp akan jadi 00:00:00
        $endDate = Carbon::create($endDateParam, 12, 0, 0)->endofDay(); // time stamp akan jadi 23:59:59
        $data = Registered::
                      leftJoin('master_numbers', 'registered.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'registered.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'registered.category_game', '=', 'category_game.id')
                        ->select(
                        'registered.id', 'registered.created_at', 'registered.master_numbers_id',
                        'master_numbers.phone', 'master_numbers.assign_to', 'master_numbers.contacted_by',
                        'category_web.name AS category_web', 
                        'category_game.name AS category_game')
                      ->whereBetween('registered.created_at', [$startDate, $endDate]) //agar lebih akurat, pakai contacted_date
                      ->orderBy('registered.id', 'desc');
      }else{
        $data = Registered::
                        leftJoin('master_numbers', 'registered.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'registered.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'registered.category_game', '=', 'category_game.id')
                        ->select(
                        'registered.id', 'registered.created_at', 'registered.master_numbers_id',
                        'master_numbers.phone', 'master_numbers.assign_to', 'master_numbers.contacted_by',
                        'category_web.name AS category_web', 
                        'category_game.name AS category_game')
                        ->orderBy('registered.id', 'desc');
      }
    }else{
      if(!empty($startDateParam) && !empty($endDateParam)){
        $startDate = Carbon::create($startDateParam, 12, 0, 0)->startOfDay(); // time stamp akan jadi 00:00:00
        $endDate = Carbon::create($endDateParam, 12, 0, 0)->endofDay(); // time stamp akan jadi 23:59:59
        $data = Registered::
                      leftJoin('master_numbers', 'registered.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'registered.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'registered.category_game', '=', 'category_game.id')
                        ->select(
                        'registered.id', 'registered.created_at', 'registered.master_numbers_id',
                        'master_numbers.phone',
                        'category_web.name AS category_web', 
                        'category_game.name AS category_game')
                      ->where('master_numbers.registered_by', '=', $user->id)
                      ->whereBetween('registered.created_at', [$startDate, $endDate]) //agar lebih akurat, pakai contacted_date
                      ->orderBy('registered.id', 'desc');
      }else{
        $data = Registered::
                        leftJoin('master_numbers', 'registered.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'registered.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'registered.category_game', '=', 'category_game.id')
                        ->select(
                        'registered.id', 'registered.created_at', 'registered.master_numbers_id',
                        'master_numbers.phone',
                        'category_web.name AS category_web', 
                        'category_game.name AS category_game')
                        ->where('master_numbers.registered_by', '=', $user->id)
                        ->orderBy('registered.id', 'desc');
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
                          if($user->can('view-registered')){
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
                          if($user->can('edit-registered')){
                            $button .= '<a href="#" class="btn btn-sm btn-info editModalBtn" data-toggle="modal" data-id="'.$query->id.'" data-master_numbers_id="'.$query->master_numbers_id.'">Edit</a>';
                          }
                          return $button;
                        })
                        ->rawColumns(['button', 'is_cs_exist'])
                        ->make(true);

  }

  public function assignto(Request $request)
  {
    $user = backpack_user();
    $idChecked = $request->ids;
    $assigntoId = $request->assignto;
    // 7381 jazz - 24 feb 2020 15:36
    $checkNumbers = Registered::whereIn('id',explode(",",$idChecked))->get();
    $masterNumbersId = [];
    foreach($checkNumbers as $value){
      $masterNumbersId[] = $value->master_numbers_id;
    }
    // where attributes
    $attributes = [
      'is_assigned' => 1,
      'assign_to' => $assigntoId,
      'contacted_by' => $assigntoId,
      'assigned_by' => $user->id,
      'assigned_date' => Carbon::now()->format('Y-m-d H:i:s'),
    ];
    // update master numbers table with above attribute
    \DB::table('master_numbers')->whereIn('id', $masterNumbersId)->update($attributes);
    Session::put('success', 'Successfully change CS.');
    return response()->json(['status'=>true,'message'=>""]);
  }

  public function update(Request $request, $id)
  {
    $user = backpack_user();
    // get all request into array
    $input = $request->all();
    //update from the modal
    $masterNumbers = MasterNumbers::FindOrFail($input['master_numbers_id']);
    $registered = Registered::FindOrFail($id);
    // if connect response not active
    if($input['is_deposit'] != 1){
      // just update master table if is_registered not equal 1
      $dataMaster = [
        'next_action_registered' => $input['next_action'],
        'is_deposit' => $input['is_deposit'],
        'note_registered' => $input['note_registered'],
      ];  
      $masterNumbers->update($dataMaster);
    }else{
      // update master table
      $dataMaster = [
        'next_action_registered' => $input['next_action'],
        'is_deposit' => $input['is_deposit'],
        'deposit_by' => $user->id,
        'deposit_date' => Carbon::now()->format('Y-m-d H:i:s'),
        'note_registered' => $input['note_registered'],
      ];
      $masterNumbers->update($dataMaster);
      // insert to registered
      $dataRegistered = [
        'master_numbers_id' => $input['master_numbers_id'],
        'category_web' => $masterNumbers->category_web,
        'category_game' => $masterNumbers->category_game,
      ];
      Players::insert($dataRegistered);
      // delete from interested table
      $registered->forceDelete($id);
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
    $user = backpack_user();
    // get all request to array
    $input = $request->all();
    $searchTerm = $input['numbers_search_box'];
    if ($user->isCs()) {
      $results = Registered::
                          leftJoin('master_numbers', 'registered.master_numbers_id', '=', 'master_numbers.id')
                          ->leftJoin('category_web', 'registered.category_web', '=', 'category_web.id')
                          ->leftJoin('category_game', 'registered.category_game', '=', 'category_game.id')
                          ->select(
                            'registered.id', 'registered.created_at', 'registered.master_numbers_id',
                            'master_numbers.phone',
                            'category_web.name AS category_web', 
                            'category_game.name AS category_game')
                          ->where('master_numbers.registered_by', '=', $user->id)
                          ->Where('master_numbers.phone', 'like', $searchTerm.'%')
                          ->orderBy('registered.id', 'desc')->get();
    }else{
      $results = Registered::
                          leftJoin('master_numbers', 'registered.master_numbers_id', '=', 'master_numbers.id')
                          ->leftJoin('category_web', 'registered.category_web', '=', 'category_web.id')
                          ->leftJoin('category_game', 'registered.category_game', '=', 'category_game.id')
                          ->select(
                            'registered.id', 'registered.created_at', 'registered.master_numbers_id',
                            'master_numbers.phone',
                            'category_web.name AS category_web', 
                            'category_game.name AS category_game')
                          ->Where('master_numbers.phone', 'like', $searchTerm.'%')
                          ->orderBy('registered.id', 'desc')->get();
    }
    return response()->json([
      json_encode($results),
    ], Response::HTTP_OK);
  }
}
