<?php

namespace App\Http\Controllers;

use App\Models\ConnectResponse;
use App\Models\MasterNumbers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Input;
use App\Post;
use DB;
use Session;
use Auth;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\CampaignResult;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\CategoryGame;
use App\Models\CategoryWeb;


class ConnectResponseController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      //
  }

  public function get_connect_response()
  {
    $data = ConnectResponse::get();
    return response()->json($data, 200);
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
    $input = $request->all();
    $data = [
        'name' => $input['connect_response_name'],
        'description' => $input['connect_response_description'],
    ];
    if(ConnectResponse::insert($data)){
      Session::put('success', 'Successfully insert.');
      return back();
    }else{
      Session::put('error', 'Fail to insert.');
      return back();
    }
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
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $input = $request->all();
    $connectResponse = ConnectResponse::findOrFail($id);
    $data = [
      'name' => $input['connectResponseName'],
      'description' => $input['connectResponseDescription'],
    ];
    if($connectResponse->update($data)){
      Session::flash('success', 'Connect Response updated.');
      return back();
    }else{
      Session::flash('error', 'Something wrong.');
      return back();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $ConnectResponse = ConnectResponse::findOrFail($id);
    if($ConnectResponse->delete()){
      Session::put('success', 'Successfully deleted.');
      return back();
    }else{
      Session::put('error', 'Fail to delete.');
      return back();
    }
  }

  public function ajaxGetById(Request $request)
  {
    $post = $request->all();
    $data = ConnectResponse::findOrFail($post['id']);
    return response()->json($data, 200);
  }
}
