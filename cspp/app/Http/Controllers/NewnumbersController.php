<?php

namespace App\Http\Controllers;

use App\Models\NewNumbers;
use App\Models\MasterNumbers;
use App\User;
use Illuminate\Http\Request;
use DB;
use Session;
use Auth;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\CategoryGame;
use App\Models\CategoryWeb;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class NewnumbersController extends Controller
{
  public function __construct()
  {
    $this->middleware(backpack_middleware());
  }
  
  public function index()
  {
    $roles = backpack_user()->whereHas("roles", function($q){ $q->where("name", "user"); })->get();
    $catWeb = CategoryWeb::select('id', 'name')->get();
    $catGames = CategoryGame::select('id', 'name')->get();
    $pageName = request()->segment(2);
    return view('numbers.newnumbers', compact('roles', 'catGames', 'catWeb', 'pageName'));
  }

  function getdata(Request $request)
  {
    $input = $request->all();
    \DB::connection()->disableQueryLog();
    if(!empty($input['startContactedDateVal'])){
      $startDateParam = $input['startContactedDateVal'];//Input::get('startContactedDateVal');
    }
    if(!empty($input['endContactedDateVal'])){
      $endDateParam = $input['endContactedDateVal'];//Input::get('endContactedDateVal');
    }
    if(!empty($startDateParam) && !empty($endDateParam)){
        $startDate = Carbon::create($startDateParam, 12, 0, 0)->startOfDay(); // time stamp akan jadi 00:00:00
        $endDate = Carbon::create($endDateParam, 12, 0, 0)->endofDay(); // time stamp akan jadi 23:59:59
        $data = NewNumbers::leftJoin('master_numbers', 'new_numbers.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'new_numbers.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'new_numbers.category_game', '=', 'category_game.id')
                        ->select('new_numbers.id', 'new_numbers.master_numbers_id', 'master_numbers.phone', 'new_numbers.created_at', 'category_web.name AS category_web', 'category_game.name AS category_game')
                        ->whereBetween('new_numbers.created_at', [$startDate, $endDate]) //agar lebih akurat, pakai contacted_date
                        ->orderBy('new_numbers.id', 'desc');
    }else{
      $data = NewNumbers::leftJoin('master_numbers', 'new_numbers.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'new_numbers.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'new_numbers.category_game', '=', 'category_game.id')
                        ->select('new_numbers.id', 'new_numbers.master_numbers_id', 'master_numbers.phone', 'new_numbers.created_at', 'category_web.name AS category_web', 'category_game.name AS category_game')
                        ->orderBy('new_numbers.id', 'desc');
    }
    return Datatables::of($data)
                        ->setTotalRecords($data->count())
                        ->editColumn('assigned_date', function ($query) {
                            return $query->assigned_date ? with(new Carbon($query->assigned_date))->format('d F Y') : '';
                        })
                        ->addColumn('button_view', '
                        <a href="#" class="btn btn-sm btn-success viewModalBtn" data-target="#viewModal" data-toggle="modal" data-id="{{$id}}" data-master_numbers_id="{{$master_numbers_id}}">View</a>
                        ')
                        ->rawColumns(['button_view'])
                        ->make(true);
  }

  public function assignto(Request $request)
  {
    $idChecked = $request->ids;
    $assigntoId = $request->assignto;
    // 7381 jazz - 24 feb 2020 15:36
    $newNumbers = NewNumbers::whereIn('id',explode(",",$idChecked))->get();
    $masterNumbersId = [];
    foreach($newNumbers as $value){
      $masterNumbersId[] = $value->master_numbers_id;
    }
    // where attributes
    $attributes = [
      'is_assigned' => 1,
      'assign_to' => $assigntoId,
      'assigned_by' => Auth::id(),
      'assigned_date' => Carbon::now()->format('Y-m-d H:i:s'),
    ];
    // update master numbers table with above attribute
    \DB::table('master_numbers')->whereIn('id', $masterNumbersId)->update($attributes);
    // get data to insert in assigned numbers table
    $dataAssigned = NewNumbers::whereIn('id',explode(",",$idChecked))->get();
    // insert data to assigned numbers table
    \DB::table('assigned')->insert($dataAssigned->toArray());
    // delete numbers in new numbers table (not use softdelete, use forceDelete instead)
    NewNumbers::whereIn('id',explode(",",$idChecked))->forceDelete();
    Session::put('success', 'Successfully assigned.');
    return response()->json(['status'=>true,'message'=>""]);
  }

  public function search(Request $request)
  {
    $input = $request->all();
    $searchTerm = $input['numbers_search_box'];
    // $searchRules = [
    //   'number_search_box' => 'required',
    // ];
    // $searchMessages = [
    //   'number_search_box.required' => 'Search term is required',
    // ];

    // $validator = Validator::make($input, $searchRules, $searchMessages);

    // if ($validator->fails()) {
    //   return response()->json([
    //     json_encode($validator),
    //   ], Response::HTTP_UNPROCESSABLE_ENTITY);
    // }
    // dd('oefeifeijf');
    $results = NewNumbers::
                        leftJoin('master_numbers', 'new_numbers.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'new_numbers.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'new_numbers.category_game', '=', 'category_game.id')
                        ->select(
                          'new_numbers.id', 'new_numbers.master_numbers_id',
                          'master_numbers.phone', 
                          'category_web.name AS category_web', 'category_game.name AS category_game')
                        ->Where('master_numbers.phone', 'like', $searchTerm.'%')
                        ->orderBy('new_numbers.id', 'desc')->get();

    // Attach roles to results
    // foreach ($results as $result) {
    //   $roles = [
    //       'roles' => $result->roles,
    //   ];
    //   $result->push($roles);
    // }

    return response()->json([
      json_encode($results),
    ], Response::HTTP_OK);
  }
}
