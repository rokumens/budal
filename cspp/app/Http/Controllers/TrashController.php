<?php

namespace App\Http\Controllers;

use App\Models\Trash;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\CategoryGame;
use App\Models\CategoryWeb;

class TrashController extends Controller
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
    $pageName = request()->segment(2);
    return view('numbers.trash', compact('roles', 'catGames', 'catWeb', 'pageName'));
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
        $data = Trash::leftJoin('master_numbers', 'trash.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'trash.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'trash.category_game', '=', 'category_game.id')
                        ->select(
                          'trash.id', 'trash.created_at', 'trash.master_numbers_id',
                          'master_numbers.phone',
                          'category_web.name AS category_web', 
                          'category_game.name AS category_game')
                      ->whereBetween('trash.created_at', [$startDate, $endDate]) //agar lebih akurat, pakai contacted_date
                      ->orderBy('trash.id', 'desc');
    }else{
      $data = Trash::leftJoin('master_numbers', 'trash.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'trash.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'trash.category_game', '=', 'category_game.id')
                        ->select(
                          'trash.id', 'trash.created_at', 'trash.master_numbers_id',
                          'master_numbers.phone',
                          'category_web.name AS category_web', 
                          'category_game.name AS category_game')
                        ->orderBy('trash.id', 'desc');
    }
    return Datatables::of($data)
                        ->setTotalRecords($data->count())
                        ->editColumn('created_at', function ($query) {
                            return $query->created_at ? with(new Carbon($query->created_at))->format('d F Y') : '';
                        })
                        ->addColumn('button_view', '
                          <a href="#" class="btn btn-sm btn-success viewModalBtn" data-toggle="modal" data-id="{{$id}}" data-master_numbers_id="{{$master_numbers_id}}">View</a>
                        ')
                        ->rawColumns(['button_view', 'button_edit'])
                        ->make(true);
  }

  public function search(Request $request)
  {
    $user = backpack_user();
    // get all request to array
    $input = $request->all();
    $searchTerm = $input['numbers_search_box'];
    $results = Trash::
                    leftJoin('master_numbers', 'trash.master_numbers_id', '=', 'master_numbers.id')
                    ->leftJoin('category_web', 'trash.category_web', '=', 'category_web.id')
                    ->leftJoin('category_game', 'trash.category_game', '=', 'category_game.id')
                    ->select(
                      'trash.id', 'trash.created_at', 'trash.master_numbers_id',
                      'master_numbers.phone',
                      'category_web.name AS category_web', 
                      'category_game.name AS category_game')
                    ->Where('master_numbers.phone', 'like', $searchTerm.'%')
                    ->orderBy('trash.id', 'desc')->get();
    return response()->json([
      json_encode($results),
    ], Response::HTTP_OK);
  }
}
