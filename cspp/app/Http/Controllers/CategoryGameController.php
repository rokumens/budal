<?php

namespace App\Http\Controllers;

use App\Models\CategoryGame;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Database\Eloquent\Model;
use Input;
use App\Post;
use DB;
use Session;
use Auth;
use Illuminate\Http\Response;
use App\Models\User;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class CategoryGameController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      //
  }

  public function ajaxGetById(Request $request)
  {
    $post = $request->all();
    $data = CategoryGame::findOrFail($post['id']);
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
        'name' => $input['category_game_name'],
    ];
    if(CategoryGame::insert($data)){
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
    $constant = CategoryGame::findOrFail($id);
    // data update
    $data = [
      'name' => $input['categoryGameName'],
    ];
    if($constant->update($data)){
      Session::put('success', 'Successfully updated.');
      return back();
    }else{
      Session::put('error', 'Fail to updated.');
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
    $constant = CategoryGame::findOrFail($id);
    if($constant->delete()){
      Session::put('success', 'Successfully deleted.');
      return back();
    }else{
      Session::put('error', 'Fail to delete.');
      return back();
    }
  }
}
