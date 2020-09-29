<?php

namespace App\Http\Controllers;

use App\Models\Assigned;
use App\Models\MasterNumbers;
use App\Models\Contacted;
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


class AssignedController extends Controller
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
    $constant = DB::table('constant_yesno')->get();
    $pageName = request()->segment(2);
    return view('numbers.assigned', compact('constant', 'roles', 'connect_response', 'campaign_result', 'next_action', 'catGames', 'catWeb', 'pageName'));
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
    if(($user->can('list-assigned-all') && $user->can('list-assigned-own')) || $user->can('list-assigned-all')){
      if(!empty($startDateParam) && !empty($endDateParam)){
        $startDate = Carbon::create($startDateParam, 12, 0, 0)->startOfDay(); // time stamp akan jadi 00:00:00
        $endDate = Carbon::create($endDateParam, 12, 0, 0)->endofDay(); // time stamp akan jadi 23:59:59
        $data = Assigned::
                      leftJoin('master_numbers', 'assigned.master_numbers_id', '=', 'master_numbers.id')
                      ->leftJoin('category_web', 'assigned.category_web', '=', 'category_web.id')
                      ->leftJoin('category_game', 'assigned.category_game', '=', 'category_game.id')
                      ->select('assigned.id', 'assigned.master_numbers_id', 'assigned.created_at', 
                      'master_numbers.phone', 'master_numbers.assign_to', 'master_numbers.contacted_by', 
                      'category_web.name AS category_web', 'category_game.name AS category_game')
                      ->whereBetween('assigned.created_at', [$startDate, $endDate]) //agar lebih akurat, pakai contacted_date
                      ->orderBy('assigned.id', 'desc');
      }else{
        $data = Assigned::
                        leftJoin('master_numbers', 'assigned.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'assigned.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'assigned.category_game', '=', 'category_game.id')
                        ->select('assigned.id', 'assigned.master_numbers_id', 'assigned.created_at', 
                        'master_numbers.phone', 'master_numbers.assign_to', 'master_numbers.contacted_by', 
                        'category_web.name AS category_web', 'category_game.name AS category_game')
                        ->orderBy('assigned.id', 'desc');
      }
    }else{
      if(!empty($startDateParam) && !empty($endDateParam)){
        $startDate = Carbon::create($startDateParam, 12, 0, 0)->startOfDay(); // time stamp akan jadi 00:00:00
        $endDate = Carbon::create($endDateParam, 12, 0, 0)->endofDay(); // time stamp akan jadi 23:59:59
        $data = Assigned::
                      leftJoin('master_numbers', 'assigned.master_numbers_id', '=', 'master_numbers.id')
                      ->leftJoin('category_web', 'assigned.category_web', '=', 'category_web.id')
                      ->leftJoin('category_game', 'assigned.category_game', '=', 'category_game.id')
                      ->select('assigned.id', 'assigned.master_numbers_id', 'master_numbers.phone', 'assigned.created_at',  'category_web.name AS category_web', 'category_game.name AS category_game')
                      ->where('master_numbers.assign_to', '=', $user->id)
                      ->whereBetween('assigned.created_at', [$startDate, $endDate]) //agar lebih akurat, pakai contacted_date
                      ->orderBy('assigned.id', 'desc');
      }else{
        $data = Assigned::
                        leftJoin('master_numbers', 'assigned.master_numbers_id', '=', 'master_numbers.id')
                        ->leftJoin('category_web', 'assigned.category_web', '=', 'category_web.id')
                        ->leftJoin('category_game', 'assigned.category_game', '=', 'category_game.id')
                        ->select('assigned.id', 'assigned.master_numbers_id', 'master_numbers.phone', 'assigned.created_at', 'category_web.name AS category_web', 'category_game.name AS category_game')
                        ->where('master_numbers.assign_to', '=', $user->id)
                        ->orderBy('assigned.id', 'desc');
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
                          if($user->can('view-assigned')){
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
                          if($user->can('edit-assigned')){
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
    $checkNumbers = Assigned::whereIn('id',explode(",",$idChecked))->get();
    $masterNumbersId = [];
    foreach($checkNumbers as $value){
      $masterNumbersId[] = $value->master_numbers_id;
    }
    // where attributes
    $attributes = [
      'is_assigned' => 1,
      'assign_to' => $assigntoId,
      'assigned_by' => $user->id,
      'assigned_date' => Carbon::now()->format('Y-m-d H:i:s'),
    ];
    // update master numbers table with above attribute
    \DB::table('master_numbers')->whereIn('id', $masterNumbersId)->update($attributes);
    Session::put('success', 'Successfully change CS.');
    return response()->json(['status'=>true,'message'=>""]);
  }

  // update in modals
  public function assignedUpdateModal(Request $request)
  {
    if($request->ajax()){
      $editModeData = Assigned::find($request->id);
      return response($editModeData);
    }
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    // gak dipake
    // public function edit($id)
    // {
    //     $contact = MasterNumbers::findOrFail($id);

    //     $data = [
    //       'contact' => $contact,
    //     ];

    //     return view('pages.user.edit')->with($data);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $user = backpack_user();
      //update from the modal
      $input = $request->all();
      $masterNumbers = MasterNumbers::FindOrFail($input['master_numbers_id']);
      $assigned = Assigned::FindOrFail($id);
      try {
        // master numbers update
        $dataMaster = [
          'is_contacted' => $input['is_contacted'],
        ];
        if($input['is_contacted'] == 1){
          $dataMaster['contacted_date'] = Carbon::now()->format('Y-m-d H:i:s');
          $dataMaster['contacted_by'] = $user->id;
        }
        $masterNumbers->update($dataMaster);
        // if contacted check box not empty or checked
        if(!empty($input['is_contacted']) AND $input['is_contacted'] != 0){
          // insert to contacted table
          $dataContacted = [
            'master_numbers_id' => $input['master_numbers_id'],
            'category_web' => $masterNumbers->category_web,
            'category_game' => $masterNumbers->category_game,
          ];
          Contacted::insert($dataContacted);
          // delete number from assigned
          $assigned->forceDelete($id);
        }

        $result = 0;
      } catch (\Exception $e) {
        $result = $e->errorInfo[1];
      }
      if ($result == 0) {
        Session::put('success', 'Successfully updated.');
        return back();
      } else {
        Session::put('error', 'Error found! Please try again.');
        return back();
      }
    }

    /**
     * Method to search for CS
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
      $user = Auth::user();
      // get all request to array
      $input = $request->all();
      $searchTerm = $input['numbers_search_box'];
      if ($user->can('view-assigned-own')) {
        $results = Assigned::
                          leftJoin('master_numbers', 'assigned.master_numbers_id', '=', 'master_numbers.id')
                          ->leftJoin('category_web', 'assigned.category_web', '=', 'category_web.id')
                          ->leftJoin('category_game', 'assigned.category_game', '=', 'category_game.id')
                          ->select('assigned.id', 'assigned.master_numbers_id', 'master_numbers.phone', 'assigned.created_at',  'category_web.name AS category_web', 'category_game.name AS category_game')
                          ->where('master_numbers.assign_to', '=', $user->id)
                          ->where('master_numbers.phone', 'like', '%'.$searchTerm.'%')
                          ->orderBy('assigned.id', 'desc')->first();
      }else{
        $results = Assigned::
                          leftJoin('master_numbers', 'assigned.master_numbers_id', '=', 'master_numbers.id')
                          ->leftJoin('category_web', 'assigned.category_web', '=', 'category_web.id')
                          ->leftJoin('category_game', 'assigned.category_game', '=', 'category_game.id')
                          ->select('assigned.id', 'assigned.master_numbers_id', 'master_numbers.phone', 'assigned.created_at',  'category_web.name AS category_web', 'category_game.name AS category_game')
                          ->where('master_numbers.phone', 'like', $searchTerm.'%')
                          ->orderBy('assigned.id', 'desc')->first();
        if($results->contacted_by == NULL){
          $user = User::find($results->assign_to);
        }else{
          $user = User::find($results->contacted_by);
        }
        if($user != NULL || $user){
          return '<a href="#" class="btn btn-sm btn-success viewModalBtn" data-toggle="modal" data-id="'.$results->id.'" data-master_numbers_id="'.$results->master_numbers_id.'">View</a>';
        }else{
          return '<a href="#" class="btn btn-sm btn-success viewModalBtn" data-toggle="modal" data-is_cs_exist="false" data-id="'.$results->id.'" data-master_numbers_id="'.$results->master_numbers_id.'">View</a>';
        }
      }
      return response()->json([
        json_encode($results),
      ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
