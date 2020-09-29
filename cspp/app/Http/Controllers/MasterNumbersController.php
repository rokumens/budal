<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterNumbers;
use Auth;

class MasterNumbersController extends Controller
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
    $data = MasterNumbers::
                        leftJoin('users AS users_assigned_by', 'users_assigned_by.id', 'master_numbers.assigned_by')
                        ->leftJoin('users AS users_assign_to', 'users_assign_to.id', 'master_numbers.assign_to')
                        ->leftJoin('users AS users_contacted_by', 'users_contacted_by.id', 'master_numbers.contacted_by')
                        ->leftJoin('users AS users_registered_by', 'users_registered_by.id', 'master_numbers.registered_by')
                        ->leftJoin('users AS users_leader', 'users_leader.id', 'master_numbers.check_1_1')
                        ->leftJoin('users AS users_deposit_by', 'users_deposit_by.id', 'master_numbers.deposit_by')
                        ->leftJoin('users AS users_deleted_by', 'users_deleted_by.id', 'master_numbers.deleted_by')
                        ->leftJoin('next_action AS action_interested', 'action_interested.id', 'master_numbers.next_action_interested')
                        ->leftJoin('next_action AS action_registered', 'action_registered.id', 'master_numbers.next_action_registered')
                        ->leftJoin('category_web', 'category_web.id', 'master_numbers.category_web')
                        ->leftJoin('category_game', 'category_game.id', 'master_numbers.category_game')
                        ->leftJoin('campaign_result', 'campaign_result.id', 'master_numbers.campaign_result')
                        ->leftJoin('connect_response AS connect_response_cs', 'connect_response_cs.id', 'master_numbers.connect_response_by_cs')
                        ->leftJoin('connect_response AS connect_response_leader_1_3', 'connect_response_leader_1_3.id', 'master_numbers.check_1_3')
                        ->select(
                          'master_numbers.*', 
                          'master_numbers.check_1_1 AS checked_by_leader',
                          'master_numbers.check_1_2 AS check_1_date_by_leader',
                          'connect_response_leader_1_3.name AS connect_response_leader_name',
                          'master_numbers.check_1_4 AS note_check_1_by_leader',
                          'users_deposit_by.name AS deposit_by_name',
                          'users_deposit_by.nik AS deposit_by_nik',
                          'users_assigned_by.name AS assigned_by_name',
                          'users_assigned_by.nik AS assigned_by_nik',
                          'users_assign_to.name AS assign_to_name',
                          'users_assign_to.nik AS assign_to_nik',
                          'users_contacted_by.name AS contacted_by_name',
                          'users_contacted_by.nik AS contacted_by_nik',
                          'users_registered_by.name AS registered_by_name',
                          'users_registered_by.nik AS registered_by_nik',
                          'users_leader.name AS users_leader_name',
                          'users_leader.nik AS users_leader_nik',
                          'users_deleted_by.name AS deleted_by_name',
                          'users_deleted_by.nik AS deleted_by_nik',
                          'category_web.name AS category_web_name',
                          'category_game.name AS category_game_name',
                          'campaign_result.name AS campaign_result_name',
                          'connect_response_cs.name AS connect_response_cs_name',
                          'action_interested.name AS next_action_interested_name',
                          'action_registered.name AS next_action_registered_name')
                        ->findOrFail($post['master_numbers_id']);
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
      //
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

  public function getfile()
  {
    if(Auth::user()->isAdmin() OR Auth::user()->isLeader()){
      redirect('/home');
    }
    $file = 'storage/uploads/format_example_A1_v1.csv';
    $name = basename($file);
    return response()->download($file, $name);
  }
}
