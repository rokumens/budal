<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class SettingNumbersController extends Controller
{
  public function __construct()
  {
    $this->settings = DB::table('orchardpools_settings')->first();
    date_default_timezone_set($this->settings->timezone);
  }

  public function index()
  {
    $data = DB::table('orchardpools_settings')->first();
    $timezone = DB::table('timezone')->orderBy('timezone', 'asc')->get();
    return view('pages/settings/numbers/index', compact('data','timezone'));
  }

  public function update(Request $request)
  {
    $post = $request->all();
    // get current settng
    $currSettings = DB::table('orchardpools_settings')->where('id', $post['id'])->first();
    // if there any change about countdown_stop OR min_count_reload_time OR max_count_reload_time
    // put it in variable
    $countDownStop = $post['countdown_stop'];
    $minRandom = $post['min_count_reload_time'];
    $maxRandom = $post['max_count_reload_time'];
    // if now time is greater than countdown stop time
    if(strtotime(date('Y-m-d H:i:s')) >= strtotime(date("Y-m-d $countDownStop:00"))){
      $draw = DB::table('orchardpools_draw')->where('date_for_number', '=', date('Y-m-d', strtotime('+1 days')))->get();
    }else{
      $draw = DB::table('orchardpools_draw')->where('date_for_number', '>=', date('Y-m-d'))->get();
    }
    // if draw data exist
    if(count($draw) > 0){
      foreach($draw as $value){
        // Add random time to each time show number
        $date_draw = $value->date_for_number; // get created at date
        $datex = date('Y-m-d', strtotime($date_draw));
        // get consolation, starter, winner from curently draw
        $consolations = DB::table('orchardpools_consolation')->where('draw_id', $value->id)->orderBy('id', 'desc')->get();
        $starter = DB::table('orchardpools_starter')->where('draw_id', $value->id)->orderBy('id', 'desc')->get();
        $winner = DB::table('orchardpools_winner')->where('draw_id', $value->id)->orderBy('id', 'desc')->get();
        $clock = $countDownStop;
        // looping update consolation
        foreach($consolations as $value){
          $randomTime = rand($minRandom, $maxRandom);
          $clock = date('H:i:s', strtotime("+$randomTime minutes", strtotime($clock)));
          DB::table('orchardpools_consolation')->where('id', $value->id)->update(['time_show'=>"$datex $clock"]);
        }
        // looping update starter
        foreach($starter as $value){
          $randomTime = rand($minRandom, $maxRandom);
          $clock = date('H:i:s', strtotime("+$randomTime minutes", strtotime($clock)));
          DB::table('orchardpools_starter')->where('id', $value->id)->update(['time_show'=>"$datex $clock"]);
        }
        // looping update winner
        foreach($winner as $value){
          $randomTime = rand($minRandom, $maxRandom);
          $clock = date('H:i:s', strtotime("+$randomTime minutes", strtotime($clock)));
          DB::table('orchardpools_winner')->where('id', $value->id)->update(['time_show'=>"$datex $clock"]);
        }
      }
    }
    DB::table('orchardpools_settings')->where('id', $post['id'])->update([
      'timezone' => $post['timezone'],
      'countdown_stop' => $post['countdown_stop'],
      'min_count_reload_time' => $post['min_count_reload_time'],
      'max_count_reload_time' => $post['max_count_reload_time'],
    ]);
    return back()->with('success', 'Succesfully updated data');
  }
}
