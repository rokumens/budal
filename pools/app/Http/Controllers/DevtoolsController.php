<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class DevtoolsController extends Controller
{

  private $date;

  public function __construct()
  {
    $this->settings = DB::table('orchardpools_settings')->first();
    date_default_timezone_set($this->settings->timezone);
  }

  public function index()
  {
    return view('devtools/index');
  }
  
  public function purge($table = NULL)
  {
    if($table == NULL){
      DB::table('orchardpools_winner')->update(['show' => 0]);
      DB::table('orchardpools_starter')->update(['show' => 0]);
      DB::table('orchardpools_consolation')->update(['show' => 0]);
    }elseif($table == 'winner'){
      DB::table('orchardpools_winner')->update(['show' => 0]);
    }elseif($table == 'orchardpools_starter'){
      DB::table('orchardpools_starter')->update(['show' => 0]);
    }elseif($table == 'orchardpools_consolation'){
      DB::table('orchardpools_consolation')->update(['show' => 0]);
    }
    return redirect('devtools/index');
  }

  public function generator()
  {
    $firstDate = DB::table('orchardpools_draw')->orderBy('id', 'asc')->first();
    $lastDate = DB::table('orchardpools_draw')->orderBy('id', 'desc')->first();
    if($firstDate != NULL || $firstDate != ''){
      $firstDate = $firstDate->date_for_number;
    }
    if($lastDate != NULL || $lastDate != ''){
      $lastDate = $lastDate->date_for_number;
    }
    return view('devtools/generator', compact('firstDate','lastDate'));
  }

  public function generate_number(Request $request)
  {
    set_time_limit(0);
    // start micro time
    $time = microtime(TRUE);
    $post = $request->all();
    $dateFromRaw = substr($post['daterange'], 0, 10);
    $dateToRaw = substr($post['daterange'], 13, 10);
    $dateFrom = date('Y-m-d', strtotime($dateFromRaw));
    $dateTo = date('Y-m-d', strtotime('+1 days', strtotime($dateToRaw)));
    $this->date = date('Y-m-d H:i:s');
    // validation
    $countDate = DB::table('orchardpools_draw')->whereDate('date_for_number', '>=', $dateFrom)->whereDate('date_for_number', '<=', $dateTo)->count();
    if($countDate > 0){
      return back()->with('error', "Sorry, you can't generate item that have date already generated. $countDate same item found in your range date.");
    }
    // get diff time
    $period = new \DatePeriod(
      new \DateTime($dateFrom),
      new \DateInterval('P1D'),
      new \DateTime($dateTo)
    );
    // loop diff in time
    foreach ($period as $key => $value) {
      $dateFor = $value->format('Y-m-d');
      $draw_no = DB::table('orchardpools_draw')->insertGetId([
        'date_for_number' => $dateFor,
        'created_at' => $this->date,
        'updated_at' => $this->date,
      ]);
      
      $dataWinner = $this->generateRandomNumber($draw_no, 3, FALSE);
      $dataConsolation = $this->generateRandomNumber($draw_no);
      // validate consolation to winner
      if($this->validationNumber($dataConsolation, $dataWinner) == TRUE){ // if true re generate number
        $dataConsolation = $this->generateRandomNumber($draw_no);
      }
      $dataStarter = $this->generateRandomNumber($draw_no);
      // validate starter to winner
      if($this->validationNumber($dataStarter, $dataWinner) == TRUE){ // if true re generate number
        $dataStarter = $this->generateRandomNumber($draw_no);
      }
      // validate starter to consolation
      if($this->validationNumber($dataStarter, $dataConsolation) == TRUE){ // if true re generate number
        $dataStarter = $this->generateRandomNumber($draw_no);
      }
      // insert data
      DB::table('orchardpools_consolation')->insert($dataConsolation);
      DB::table('orchardpools_starter')->insert($dataStarter);
      DB::table('orchardpools_winner')->insert($dataWinner);

      $consolations = DB::table('orchardpools_consolation')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
      $starter = DB::table('orchardpools_starter')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
      $winner = DB::table('orchardpools_winner')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
      // get min and max random reload time from setting
      $minRandom = $this->settings->min_count_reload_time;
      $maxRandom = $this->settings->max_count_reload_time;
      $clock = $this->settings->countdown_stop;
      // looping update consolation
      foreach($consolations as $value){
        $randomTime = rand($minRandom, $maxRandom);
        $clock = date("$dateFor H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
        DB::table('orchardpools_consolation')->where('id', $value->id)->update(['time_show'=>"$clock"]);
      }
      // looping update starter
      foreach($starter as $value){
        $randomTime = rand($minRandom, $maxRandom);
        $clock = date("$dateFor H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
        DB::table('orchardpools_starter')->where('id', $value->id)->update(['time_show'=>"$clock"]);
      }
      // looping update winner
      foreach($winner as $value){
        $randomTime = rand($minRandom, $maxRandom);
        $clock = date("$dateFor H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
        DB::table('orchardpools_winner')->where('id', $value->id)->update(['time_show'=>"$clock"]);
      }
    }
    // get total time execution
    $timeOut = microtime(TRUE)-$time;
    return back()->with('success', "Time : $timeOut");
  }

  public function generatetimeshow()
  {
    $settings = DB::table('orchardpools_settings')->first();
    $minRandom = $settings->min_count_reload_time;
    $maxRandom = $settings->max_count_reload_time;

    $countDownStop = $this->settings->countdown_stop;
    $draw_no = DB::table('orchardpools_draw')->max('id');
    // Add random time to each time show number
    $date_draw = DB::table('orchardpools_draw')->where('id', $draw_no)->first()->created_at; // get created at date
    $datex = date('Y-m-d', strtotime($date_draw));
    // get consolation, starter, winner from curently draw
    $consolations = DB::table('orchardpools_consolation')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
    $starter = DB::table('orchardpools_starter')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
    $winner = DB::table('orchardpools_winner')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
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
    return redirect('devtools/index');
  }

  public function truncate($type = 'all')
  {
    if($type == 'all'){
      DB::table('orchardpools_consolation')->truncate();
      DB::table('orchardpools_starter')->truncate();
      DB::table('orchardpools_winner')->truncate();
      DB::table('orchardpools_draw')->truncate();
      $message = 'Success truncate table';
    }elseif($type == 'today'){
      $currentDraw = DB::table('orchardpools_draw')->whereDate('date_for_number', date('Y-m-d'))->first();
      DB::table('orchardpools_consolation')->where('draw_id', $currentDraw->id)->delete();
      DB::table('orchardpools_starter')->where('draw_id', $currentDraw->id)->delete();
      DB::table('orchardpools_winner')->where('draw_id', $currentDraw->id)->delete();
      DB::table('orchardpools_draw')->whereDate('date_for_number', date('Y-m-d'))->delete();
      $message = 'Success delete today number';
    }else{
      $message = 'Invalid';
    }
    return back()->with('success', $message);
  }

  private function generateRandomNumber($draw_no, $totalGen = 6, $increment = FALSE)
  {
    $data = [];
    for ($i=1; $i <= $totalGen; $i++) { 
      if($increment == TRUE){
        $data[] = [
          'number' => substr(str_shuffle(str_repeat($x='0123456789', ceil(6/strlen($x)) )),1,6),// random string function
          'prize' => $i + 1,
          'draw_id' => $draw_no,
          'created_at' => $this->date,
          'updated_at' => $this->date,
        ];
      }else{
        $data[] = [
          'number' => substr(str_shuffle(str_repeat($x='0123456789', ceil(6/strlen($x)) )),1,6),// random string function
          'prize' => $i,
          'draw_id' => $draw_no,
          'created_at' => $this->date,
          'updated_at' => $this->date,
        ];
      }
    }
    return $data;
  }

  private function validationNumber($number = [], $data = [])
  {
    $return = FALSE;
    foreach($data as $vData){
      foreach($number as $vNumber){
        // return true if any exist number with same value
        if(in_array($vData['number'], $vNumber)){
          $return = TRUE;
        }
      }
    }
    return $return;
  }

}
