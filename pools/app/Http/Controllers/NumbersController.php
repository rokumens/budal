<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orchardpools;
use DB;
use Validator;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class NumbersController extends Controller
{
  private $date;

  public function __construct()
  {
    $this->settings = DB::table('orchardpools_settings')->first();
    date_default_timezone_set($this->settings->timezone);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $numbers = DB::table('orchardpools_winner AS winner')->leftJoin('orchardpools_draw AS draw', 'draw.id', 'winner.draw_id')->select('winner.id', 'winner.number', 'winner.created_at','winner.draw_id','winner.created_at','winner.time_show','draw.date_for_number')->where('winner.prize', 1)->orderBy('draw.date_for_number', 'desc')->paginate(10);
    return view('pages/numbers/index', compact('numbers'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $post = $request->all();
    $settings = DB::table('orchardpools_settings')->first();
    // get min and max random reload time from setting
    $minRandom = $settings->min_count_reload_time;
    $maxRandom = $settings->max_count_reload_time;
    // put date_for_number post into variable
    $date_for_number = $post['date_for_number'];

    $validator = Validator::make(
      $request->all(),
      [
        'number' => 'required|numeric|digits:6',
        'date_for_number' => 'required'
      ],
    );
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
    // $countRows = DB::table('orchardpools_draw')->where('is_open', 1)->count();
    $countRowsDate = DB::table('orchardpools_draw')->whereDate('date_for_number', '=', $post['date_for_number'])->count();
    if($countRowsDate > 0){
      $drawOpen = DB::table('orchardpools_draw')->whereDate('date_for_number', '=', $post['date_for_number'])->first();
      return back()->withErrors("Number already exist at date ".date('d F Y', strtotime($drawOpen->date_for_number)));
    }
    if(strtotime(date("$date_for_number H:i:s")) < strtotime(date('Y-m-d H:i:s'))){
      return back()->withErrors("You can't generate number on the past date.");
    }
    $this->date = date('Y-m-d H:i:s');
    $countDownStop = $this->settings->countdown_stop;
    DB::table('orchardpools_draw')->insert([
      'date_for_number' => $post['date_for_number'],
      'created_at' => $this->date,
      'updated_at' => $this->date,
    ]);
    $draw_no = DB::table('orchardpools_draw')->max('id');

    // prepare data
    $data[] = [
      'number' => $post['number'],
      'prize' => 1,
      'draw_id' => $draw_no,
      'created_at' => $this->date,
      'updated_at' => $this->date,
    ];
    // generate winner
    $dataWinner = $this->generateRandomNumber($draw_no, 2, TRUE);
    // validate winner to 1st prize
    if($this->validationNumber($dataWinner, $data) == TRUE){ // if true re generate number
      $dataWinner = $this->generateRandomNumber($draw_no);
    }
    // merge 1st with 2nd and 3rd
    $data[] = $dataWinner[0];
    $data[] = $dataWinner[1];
    // generate consolation
    $dataConsolation = $this->generateRandomNumber($draw_no);
    // validate consolation to winner
    if($this->validationNumber($dataConsolation, $data) == TRUE){ // if true re generate number
      $dataConsolation = $this->generateRandomNumber($draw_no);
    }
    // generate starter
    $dataStarter = $this->generateRandomNumber($draw_no);
    // validate starter to winner
    if($this->validationNumber($dataStarter, $data) == TRUE){ // if true re generate number
      $dataStarter = $this->generateRandomNumber($draw_no);
    }
    // validate starter to consolation
    if($this->validationNumber($dataStarter, $dataConsolation) == TRUE){ // if true re generate number
      $dataStarter = $this->generateRandomNumber($draw_no);
    }
    // insert data
    DB::table('orchardpools_consolation')->insert($dataConsolation);
    DB::table('orchardpools_starter')->insert($dataStarter);
    DB::table('orchardpools_winner')->insert($data);

    // Add random time to each time show number
    // $date_draw = DB::table('orchardpools_draw')->where('id', $draw_no)->first()->created_at; // get created at date
    $datex = $this->date;
    // get consolation, starter, winner from curently draw
    $consolations = DB::table('orchardpools_consolation')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
    $starter = DB::table('orchardpools_starter')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
    $winner = DB::table('orchardpools_winner')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
    $clock = $countDownStop;
    $postDate = $post['date_for_number'];
    // looping update consolation
    foreach($consolations as $value){
      $randomTime = rand($minRandom, $maxRandom);
      // $clock = date('H:i:s', strtotime("+$randomTime minutes", strtotime($clock))); date('Y-m-d H:i:s',strtotime("+$randomTime minutes",strtotime($datex)));
      $clock = date("$postDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
      DB::table('orchardpools_consolation')->where('id', $value->id)->update(['time_show'=>"$clock"]);
    }
    // looping update starter
    foreach($starter as $value){
      $randomTime = rand($minRandom, $maxRandom);
      $clock = date("$postDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
      DB::table('orchardpools_starter')->where('id', $value->id)->update(['time_show'=>"$clock"]);
    }
    // looping update winner
    foreach($winner as $value){
      $randomTime = rand($minRandom, $maxRandom);
      $clock = date("$postDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
      DB::table('orchardpools_winner')->where('id', $value->id)->update(['time_show'=>"$clock"]);
    }
    return back()->with('success', 'Succesfully generate number');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request)
  {
    $post = $request->all();
    $data = DB::table('orchardpools_winner')->where('id', $post['id'])->first();
    return response()->json($data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $post = $request->all();

    $number = DB::table('orchardpools_winner')->where('id', $post['id'])->first();

    $validator = Validator::make($request->all(),[
        'number' => 'required|numeric|digits:6',
      ],
    );
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
    if(strtotime(date('Y-m-d H:i:s')) >= strtotime($number->time_show)){
      return back()->withErrors("Sorry you can't edit number that already show.");
    }
    DB::table('orchardpools_winner')->where('id', $post['id'])->update([
      'number' => $post['number'],
    ]);
    return back()->with('success', 'Succesfully updated number');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    DB::table('orchardpools_winner')->where('id', $id)->delete();
    return back()->with('success', 'Succesfully deleted number');
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

  public function prize($id)
  {
    $consolation = DB::table('orchardpools_consolation')->where('draw_id', $id)->get();
    $starter = DB::table('orchardpools_starter')->where('draw_id', $id)->get();
    $winner = DB::table('orchardpools_winner')->where('draw_id', $id)->get();
    $date = DB::table('orchardpools_draw')->where('id', $id)->first()->date_for_number;
    return view('pages/numbers/prize', compact('consolation', 'starter', 'winner', 'date'));
  }
}
