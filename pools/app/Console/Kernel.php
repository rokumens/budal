<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;

class Kernel extends ConsoleKernel
{
  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
      Commands\DeleteExpiredActivations::class,
  ];

  /**
   * Define the application's command schedule.
   *
   * @param \Illuminate\Console\Scheduling\Schedule $schedule
   *
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {
      #cron generate numbers winner, starter, consolation.
      #$schedule->call(function () {$this->cronGenerate();})->everyTenMinutes();
      $schedule->call(function(){$this->cronGenerate();})->dailyAt('00:01');
      $schedule->command('activations:clean')->daily();
      // luffy 7 April 2020 08:41 pm
      # tiap 12 jam
      // $schedule->command('cache:flush')->cron('0 */12 * * *');
      // $schedule->command('session:flush')->cron('0 */12 * * *');hours
      #tiap hari jam 09:00 & 21:00
      $schedule->command('cache:flush')->twiceDaily(9, 21);
      $schedule->command('session:flush')->twiceDaily(9, 21);
  }

  /**
   * Register the Closure based commands for the application.
   *
   * @return void
   */
  protected function commands()
  {
      $this->load(__DIR__.'/Commands');
      require base_path('routes/console.php');
  }

  private function cronGenerate()
  {
    $setting = DB::table('orchardpools_settings')->first();
    $todayDate = date('Y-m-d');
    $countItemInDate = DB::table('orchardpools_draw')->whereDate('date_for_number', $todayDate)->count();
    // if in databse not have same date
    if($countItemInDate == 0){
      // if launching date not empty
      if($setting->launching_date != NULL || $setting->launching_date != ''){
        // if today not more than launching date
        if(strtotime($todayDate) < strtotime($setting->launching_date)){
          $draw_no = DB::table('orchardpools_draw')->insertGetId([
            'date_for_number' => $todayDate
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
          $minRandom = $setting->min_count_reload_time;
          $maxRandom = $setting->max_count_reload_time;
          $clock = $setting->countdown_stop;
          // looping update consolation
          foreach($consolations as $value){
            $randomTime = rand($minRandom, $maxRandom);
            $clock = date("$todayDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
            DB::table('orchardpools_consolation')->where('id', $value->id)->update(['time_show'=>"$clock"]);
          }
          // looping update starter
          foreach($starter as $value){
            $randomTime = rand($minRandom, $maxRandom);
            $clock = date("$todayDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
            DB::table('orchardpools_starter')->where('id', $value->id)->update(['time_show'=>"$clock"]);
          }
          // looping update winner
          foreach($winner as $value){
            $randomTime = rand($minRandom, $maxRandom);
            $clock = date("$todayDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
            DB::table('orchardpools_winner')->where('id', $value->id)->update(['time_show'=>"$clock"]);
          }
        }
      }else{
        $draw_no = DB::table('orchardpools_draw')->insertGetId([
          'date_for_number' => $todayDate
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
        $minRandom = $setting->min_count_reload_time;
        $maxRandom = $setting->max_count_reload_time;
        $clock = $setting->countdown_stop;
        // looping update consolation
        foreach($consolations as $value){
          $randomTime = rand($minRandom, $maxRandom);
          $clock = date("$todayDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
          DB::table('orchardpools_consolation')->where('id', $value->id)->update(['time_show'=>"$clock"]);
        }
        // looping update starter
        foreach($starter as $value){
          $randomTime = rand($minRandom, $maxRandom);
          $clock = date("$todayDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
          DB::table('orchardpools_starter')->where('id', $value->id)->update(['time_show'=>"$clock"]);
        }
        // looping update winner
        foreach($winner as $value){
          $randomTime = rand($minRandom, $maxRandom);
          $clock = date("$todayDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
          DB::table('orchardpools_winner')->where('id', $value->id)->update(['time_show'=>"$clock"]);
        }
      }
    }
  }

  private function generateRandomNumber($draw_no, $totalGen = 6, $increment = FALSE)
  {
    $data = [];
    for ($i=1; $i <= $totalGen; $i++) { 
      if($increment == TRUE){
        $data[] = [
          'number' => substr(str_shuffle(str_repeat($x='0123456789', ceil(6/strlen($x)) )),1,6),// random string function
          'prize' => $i + 1,
          'draw_id' => $draw_no
        ];
      }else{
        $data[] = [
          'number' => substr(str_shuffle(str_repeat($x='0123456789', ceil(6/strlen($x)) )),1,6),// random string function
          'prize' => $i,
          'draw_id' => $draw_no
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
