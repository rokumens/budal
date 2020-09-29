<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AjaxController extends Controller
{
  public function __construct()
  {
    $this->settings = DB::table('orchardpools_settings')->first();
    date_default_timezone_set($this->settings->timezone);
  }

  public function gettime(Request $request)
  {
    $post = $request->all();
    $prizeName = $post['prize_name'];
    $data = DB::table("orchardpools_$prizeName")->whereDate('created_at', date('Y-m-d'))->where('prize', $post['prize_id'])->first();
    return response()->json($data);
  }

  public function getNumberByDate(Request $request)
  {
    $post = $request->all();
    $liveDraw = DB::table('orchardpools_draw')->whereDate('date_for_number', '=', $post['date'])->first();
    if($liveDraw){
      $data = [
        'winner' => DB::table('orchardpools_winner')->where('draw_id', $liveDraw->id)->get(),
        'starter' => DB::table('orchardpools_starter')->where('draw_id', $liveDraw->id)->get(),
        'consolation' => DB::table('orchardpools_consolation')->where('draw_id', $liveDraw->id)->get(),
        'date' => date('l, d F Y', strtotime($liveDraw->date_for_number)),
        'draw_id' => $liveDraw->id,
      ];
    }else{
      $data = FALSE;
    }
    return response()->json($data);
  }
}
