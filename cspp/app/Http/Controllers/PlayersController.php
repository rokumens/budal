<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\MasterNumbers;
use App\User;
use Illuminate\Http\Request;
use Input;
use DB;
use Session;
use Auth;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\CategoryGame;
use App\Models\CategoryWeb;

class PlayersController extends Controller
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
    $pageName = request()->segment(2);
    return view('numbers.players', compact('constant', 'roles', 'catGames', 'catWeb', 'pageName'));
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
        $data = Players::
                      leftJoin('master_numbers', 'players.master_numbers_id', '=', 'master_numbers.id')
                      ->leftJoin('category_web', 'players.category_web', '=', 'category_web.id')
                      ->leftJoin('category_game', 'players.category_game', '=', 'category_game.id')
                      ->select(
                      'players.id', 'players.created_at', 'players.master_numbers_id',
                      'master_numbers.phone',
                      'category_web.name AS category_web', 
                      'category_game.name AS category_game')
                      ->whereBetween('players.created_at', [$startDate, $endDate]) //agar lebih akurat, pakai contacted_date
                      ->orderBy('players.id', 'desc');
    }else{
      $data = Players::
          leftJoin('master_numbers', 'players.master_numbers_id', '=', 'master_numbers.id')
                    ->leftJoin('category_web', 'players.category_web', '=', 'category_web.id')
                    ->leftJoin('category_game', 'players.category_game', '=', 'category_game.id')
                    ->select(
                    'players.id', 'players.created_at', 'players.master_numbers_id',
                    'master_numbers.phone',
                    'category_web.name AS category_web', 
                    'category_game.name AS category_game')
                    ->orderBy('players.id', 'desc');
    }
    return Datatables::of($data)
                        ->setTotalRecords($data->count())
                        ->editColumn('created_at', function ($query) {
                            return $query->created_at ? with(new Carbon($query->created_at))->format('d F Y') : '';
                        })
                        ->addColumn('button_view', '
                          <a href="#" class="btn btn-sm btn-success viewModalBtn mr-2" data-target="#viewModal" data-toggle="modal" data-id="{{$id}}" data-master_numbers_id="{{$master_numbers_id}}">View</a>
                        ')
                        ->addColumn('button_edit', '
                          <a href="#" class="btn btn-sm btn-info editModalBtn" data-toggle="modal" data-id="{{$id}}" data-master_numbers_id="{{$master_numbers_id}}">Edit</a>
                        ')
                        ->rawColumns(['button_edit', 'button_view'])
                        ->make(true);

  }

  public function update(Request $request, $id)
  {
    $user = backpack_user();
    // get all request into array
    $input = $request->all();
    //update from the modal
    $masterNumbers = MasterNumbers::FindOrFail($input['master_numbers_id']);
    $registered = Players::FindOrFail($id);
    // if connect response not active
    if($input['is_deposit'] != 1){
      // just update master table if is_registered not equal 1
      $dataMaster = [
        'is_deposit' => $input['is_deposit'],
      ];  
      $masterNumbers->update($dataMaster);
    }else{
      // update master table
      $dataMaster = [
        'is_deposit' => $input['is_deposit'],
      ];
      $masterNumbers->update($dataMaster);
      // insert to registered
      $dataPlayers = [
        'master_numbers_id' => $input['master_numbers_id'],
        'category_web' => $masterNumbers->category_web,
        'category_game' => $masterNumbers->category_game,
      ];
      Players::insert($dataPlayers);
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
    $user = Auth::user();
    // get all request to array
    $input = $request->all();
    $searchTerm = $input['numbers_search_box'];
    if ($user->isCs()) {
      $results = Players::
                      leftJoin('master_numbers', 'players.master_numbers_id', '=', 'master_numbers.id')
                      ->leftJoin('category_web', 'players.category_web', '=', 'category_web.id')
                      ->leftJoin('category_game', 'players.category_game', '=', 'category_game.id')
                      ->select(
                      'players.id', 'players.created_at', 'players.master_numbers_id',
                      'master_numbers.phone',
                      'category_web.name AS category_web', 
                      'category_game.name AS category_game')
                      ->where('master_numbers.contacted_by', '=', $user->id)
                      ->Where('master_numbers.phone', 'like', $searchTerm.'%')
                      ->orderBy('players.id', 'desc')->get();
    }else{
      $results = Players::
                      leftJoin('master_numbers', 'players.master_numbers_id', '=', 'master_numbers.id')
                      ->leftJoin('category_web', 'players.category_web', '=', 'category_web.id')
                      ->leftJoin('category_game', 'players.category_game', '=', 'category_game.id')
                      ->select(
                      'players.id', 'players.created_at', 'players.master_numbers_id',
                      'master_numbers.phone',
                      'category_web.name AS category_web', 
                      'category_game.name AS category_game')
                      ->Where('master_numbers.phone', 'like', $searchTerm.'%')
                      ->orderBy('players.id', 'desc')->get();
    }
    return response()->json([
      json_encode($results),
    ], Response::HTTP_OK);
  }
}
