<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\ConstantYesno;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\ConnectResponse;
use App\Models\CampaignResult;
use App\Models\NextAction;
use App\Models\CategoryGame;
use App\Models\CategoryWeb;

class SettingsController extends Controller
{
  public function __construct()
  {
    $this->middleware(backpack_middleware());
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user = backpack_user();
    $settings = new Settings;
    $option = $settings->findOrFail(1);
    $constant = ConstantYesno::get();
    $connectResponse = ConnectResponse::get();
    $campaignResult = CampaignResult::get();
    $categoryGame = CategoryGame::get();
    $categoryWeb = CategoryWeb::get();
    $nextAction = NextAction::get();
    $pageName = request()->segment(1);
    return view('settings', compact('constant', 'connectResponse', 'campaignResult', 'nextAction', 'categoryGame', 'categoryWeb', 'pageName', 'option'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $input = $request->all();
    $data = [
      'name' => $input['constant_name'],
      'value' => $input['constant_value'],
    ];
    if(ConstantYesno::insert($data)){
      Session::put('success', 'Successfully insert.');
      return back();
    }else{
      Session::put('error', 'Fail to insert.');
      return back();
    }
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
   * @param  \App\Models\Settings  $settings
   * @return \Illuminate\Http\Response
   */
  public function show(Settings $settings)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Settings  $settings
   * @return \Illuminate\Http\Response
   */
  public function edit(Settings $settings)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Settings  $settings
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Settings $settings)
  {
    $input = $request->all();
    $settings = Settings::findOrFail(1);

    $existingAssignTimesPrevious = $settings->assigned_times_previous;
    $existingAssignTimesNow = $settings->assigned_times_now;
    $existingAssignTimesMax = $settings->assigned_times_max;
    $requestAssignTimes = $input['assigned_times'];

    if($requestAssignTimes > $existingAssignTimesNow && $requestAssignTimes > $existingAssignTimesMax){
      // $diffAssignedTimes = $requestAssignTimes - $existingAssignTimesNow + 1;
      for ($i=$existingAssignTimesMax+1; $i <= $requestAssignTimes; $i++) {
        DB::table('master_numbers')->select(DB::statement("
          ALTER TABLE `master_numbers` 
          ADD `check_".$i."_1` INT(11) NULL DEFAULT NULL COMMENT 'check by leader' AFTER `check_".($i-1)."_4`, 
          ADD `check_".$i."_2` DATETIME NULL DEFAULT NULL COMMENT 'check date by leader' AFTER `check_".$i."_1`, 
          ADD `check_".$i."_3` INT(11) NULL DEFAULT NULL COMMENT 'check connect response by leader	' AFTER `check_".$i."_2`, 
          ADD `check_".$i."_4` TEXT NULL DEFAULT NULL COMMENT 'check note by leader' AFTER `check_".$i."_3`;
        "));
      }
      $settings->update([
        'assigned_times_max' => $requestAssignTimes,
      ]);
    }
    
    $dataSettings = [
      'contacted_times' => $input['contacted_times'],
      'assigned_times_previous' => $existingAssignTimesNow,
      'assigned_times_now' => $requestAssignTimes,
    ];
    if($settings->update($dataSettings)){
      Session::flash('success', 'Settings updated.');
      return back();
    }else{
      Session::flash('error', 'Something wrong.');
      return back();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Settings  $settings
   * @return \Illuminate\Http\Response
   */
  public function destroy(Settings $settings)
  {
    
  }
}
