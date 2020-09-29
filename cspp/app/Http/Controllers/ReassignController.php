<?php

namespace App\Http\Controllers;

use App\Models\Reassign;
use App\Models\Trash;
use App\Models\Assigned;
use App\Models\MasterNumbers;
use App\User;
use Illuminate\Http\Request;
use Input;
use DB;
use Auth;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\CategoryGame;
use App\Models\CategoryWeb;

class ReassignController extends Controller
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
    // jazz 7381 21 februari 2020 15:51 - default controller name
    $pageName = request()->segment(3);
    return view('numbers.leader.reassign', compact('roles', 'catGames', 'catWeb', 'pageName'));
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

    if(!empty($startDateParam) && !empty($endDateParam)){
        $startDate = Carbon::create($startDateParam, 12, 0, 0)->startOfDay(); // time stamp akan jadi 00:00:00
        $endDate = Carbon::create($endDateParam, 12, 0, 0)->endofDay(); // time stamp akan jadi 23:59:59
        $data = Reassign::leftJoin('master_numbers', 'reassign.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'reassign.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'reassign.category_game', '=', 'category_game.id')
                        ->select(
                          'reassign.id', 'reassign.created_at', 'reassign.master_numbers_id',
                          'master_numbers.phone',
                          'category_web.name AS category_web', 
                          'category_game.name AS category_game')
                      ->whereBetween('reassign.created_at', [$startDate, $endDate]) //agar lebih akurat, pakai contacted_date
                      ->orderBy('reassign.id', 'desc');
    }else{
      $data = Reassign::leftJoin('master_numbers', 'reassign.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'reassign.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'reassign.category_game', '=', 'category_game.id')
                        ->select(
                          'reassign.id', 'reassign.created_at', 'reassign.master_numbers_id',
                          'master_numbers.phone',
                          'category_web.name AS category_web', 
                          'category_game.name AS category_game')
                        ->orderBy('reassign.id', 'desc');
    }
    return Datatables::of($data)
                        ->setTotalRecords($data->count())
                        ->editColumn('created_at', function ($query) {
                            return $query->created_at ? with(new Carbon($query->created_at))->format('d F Y') : '';
                        })
                        ->addColumn('button', '
                          <a href="#" class="btn btn-sm btn-success viewModalBtn" data-toggle="modal" data-id="{{$id}}" data-master_numbers_id="{{$master_numbers_id}}">View</a>
                        ')
                        ->rawColumns(['button'])
                        ->make(true);
  }

  public function multipleDelete(Request $request)
  {
    $user = backpack_user();
    $ids = $request->ids;
    // get data in reassign table by id
    $reassign = Reassign::whereIn('id',explode(",",$ids))->get();
    foreach($reassign as $value){
      // prepare data to insert in deleted table
      $data = [
        'master_numbers_id' => $value->master_numbers_id,
        'category_web' => $value->category_web,
        'category_game' => $value->category_game,
      ];
      Trash::insert($data);
      // update master
      $deletedBy = MasterNumbers::FindOrFail($value->master_numbers_id);
      $dataMaster = [
          'deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'deleted_by' => $user->id,
      ];
      $deletedBy->update($dataMaster);
    }
    // delete data number from reassign table
    Reassign::whereIn('id',explode(",",$ids))->forceDelete();
    return response()->json(['status'=>true,'message'=>"Contact(s) successfully deleted!"]);
  }

  /**
  * to Assign To
  *
  * @return \Illuminate\Http\Response
  */
  public function assignto(Request $request)
  {
    $user = backpack_user();
    $idChecked = $request->ids;
    $assigntoId = $request->assignto;
    $whereMasterNumbersId = [];
    $reassign = Reassign::whereIn('id',explode(",",$idChecked))->get();
    foreach($reassign as $value){
      // prepare data in array for update master_numbers table
      $whereMasterNumbersId[] = $value->master_numbers_id;
      // insert data to assigned table
      $dataAssigned = [
        'master_numbers_id' => $value->master_numbers_id,
        'category_web' => $value->category_web,
        'category_game' => $value->category_game,
      ];
      Assigned::insert($dataAssigned);
    }

    \DB::table('master_numbers')->whereIn('id', $whereMasterNumbersId)->update([
      'is_assigned' => 1,
      'assign_to' => $assigntoId,
      'assigned_by' => $user->id,
      'assigned_date' => Carbon::now()->format('Y-m-d H:i:s'),
      'campaign_result' => NULL,
      'connect_response_by_cs' => NULL,
      'note_contacted' => NULL,
      'is_assigned' => 1,
      'is_contacted' => 0,
      'contacted_date' => NULL,
      'contacted_times' => 0,
      'contacted_by' => NULL,
      'assigned_times' => 0,
    ]);
    Reassign::whereIn('id',explode(",",$idChecked))->forceDelete();
    return response()->json(['status'=>true,'message'=>"Contact(s) successfully assigned!"]);
  }

  public function search(Request $request)
  {
    $input = $request->all();
    $searchTerm = $input['numbers_search_box'];
    $results = Reassign::
                        leftJoin('master_numbers', 'reassign.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'reassign.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'reassign.category_game', '=', 'category_game.id')
                        ->select(
                          'reassign.id', 'reassign.created_at', 'reassign.master_numbers_id',
                          'master_numbers.phone',
                          'category_web.name AS category_web', 
                          'category_game.name AS category_game')
                        ->Where('master_numbers.phone', 'like', $searchTerm.'%')
                        ->orderBy('reassign.id', 'desc')->get();
    return response()->json([
      json_encode($results),
    ], Response::HTTP_OK);
  }
}
