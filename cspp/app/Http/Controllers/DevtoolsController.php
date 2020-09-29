<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterNumbers;
use Rajbatch\Batchquery\Batchquery;
use Batch;
use App\Models\NewNumbers;
use App\Models\Assigned;
use App\Models\Contacted;
use App\Models\Interested;
use App\Models\Registered;
use App\Models\Check;
use App\Models\Reassign;
use App\Models\Players;
use App\Models\Trash;
use Illuminate\Support\Facades\Cache;
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
use Carbon\Carbon;

class DevtoolsController extends Controller
{
  // parent databse
  public function database()
  {
    $countMaster = MasterNumbers::count();
    $countNewNumbers = NewNumbers::count();
    $countAssigned = Assigned::count();
    $countContacted = Contacted::count();
    $countInterested = Interested::count();
    $countRegistered = Registered::count();
    $countCheck = Check::count();
    $countReassign = Reassign::count();
    $countPlayers = Players::count();
    $countTrash = Trash::count();
    $countTotal = $countNewNumbers + $countAssigned + $countContacted + $countInterested + $countRegistered + $countCheck + $countReassign + $countPlayers + $countTrash;
    $pageName = request()->segment(3);
    return view('devtools.database', compact('pageName', 'countMaster','countNewNumbers','countAssigned','countContacted','countInterested','countRegistered','countCheck','countReassign','countPlayers','countTrash','countTotal'));
  }

  public function step_1($bot = FALSE)//new numbers
  {
    // must include (server option)
    DB::disableQueryLog();
    ini_set("memory_limit",'-1');
    ini_set('max_execution_time', 3000);
    ini_set('auto_detect_line_endings', true);
    DB::table('new_numbers')->truncate();
    $start = microtime(true);
    $chunkSize = 2500;

    $where = [
      'is_assigned' => 0,
    ];
    $idDUmp = [];
    MasterNumbers::where($where)->chunkById($chunkSize, function($chunksMaster) use(&$idDUmp){
      foreach($chunksMaster as $key => $v){
        $data = [
          'master_numbers_id' => $v->id,
          'category_web' => $v->category_web, 
          'category_game' => $v->category_game,
        ];
        $dataInsert[] = $data;
        $idDUmp[] = $v->id;
      }
      \DB::table('new_numbers')->insert($dataInsert);
      unset($dataInsert);
    });
    $time = microtime(true) - $start;
    if($bot == FALSE){
      return redirect('/devtools/database')->with('success', "New numbers insert successfully. Execution time : $time");
    }else{
      return [
        'type' => TRUE,
        'time' => $time,
        'id' => $idDUmp,
      ];
    }
  }

  public function step_2($bot = FALSE)//assigned
  {
    // must include (server option)
    DB::disableQueryLog();
    ini_set("memory_limit",'-1');
    ini_set('max_execution_time', 3000);
    ini_set('auto_detect_line_endings', true);
    DB::table('assigned')->truncate();
    $start = microtime(true);
    $chunkSize = 2500;

    $where = [
      'is_assigned' => 1,
      'is_contacted' => 0
    ];
    $idDUmp = [];
    MasterNumbers::where($where)->chunkById($chunkSize, function($chunksMaster) use(&$idDUmp){
      foreach($chunksMaster as $key => $v){
        $data = [
            'master_numbers_id' => $v->id,
            'category_web' => $v->category_web, 
            'category_game' => $v->category_game,
        ];
        $dataInsert[] = $data;
        $idDUmp[] = $v->id;
      }
      \DB::table('assigned')->insert($dataInsert);
      unset($dataInsert);
    });
    $time = microtime(true) - $start;
    if($bot == FALSE){
      return redirect('/devtools/database')->with('success', "Assigned insert successfully. Execution time : $time");
    }else{
      return [
        'type' => TRUE,
        'time' => $time,
        'id' => $idDUmp,
      ];
    }
  }

  public function step_3($bot = FALSE)//contacted
  {
    // must include (server option)
    DB::disableQueryLog();
    ini_set("memory_limit",'-1');
    ini_set('max_execution_time', 3000);
    ini_set('auto_detect_line_endings', true);
    DB::table('contacted')->truncate();
    $start = microtime(true);
    $chunkSize = 2500;

    $where = [
      'is_contacted' => 1,
    ];
    $idDUmp = [];
    MasterNumbers::where($where)->whereNotNull('campaign_result')->whereNotNull('connect_response_by_cs')->chunkById($chunkSize, function($chunksMaster) use(&$idDUmp){
      foreach($chunksMaster as $key => $v){
        // start prepare data insert
        $dataInsert[] = [
          'master_numbers_id' => $v->id,
          'category_web' => $v->category_web, 
          'category_game' => $v->category_game,
        ];
        $idDUmp[] = $v->id;
      }
      // delete data assigned
      \DB::table('contacted')->insert($dataInsert);
      unset($dataInsert);
    });
    $time = microtime(true) - $start;
    // dd($time);
    if($bot == FALSE){
      return redirect('/devtools/database')->with('success', "Contacted insert successfully. Execution time : $time");
    }else{
      return [
        'type' => TRUE,
        'time' => $time,
        'id' => $idDUmp,
      ];
    }
  }

  public function step_4($bot = FALSE)//interested
  {
    // must include (server option)
    DB::disableQueryLog();
    ini_set("memory_limit",'-1');
    ini_set('max_execution_time', 3000);
    ini_set('auto_detect_line_endings', true);
    DB::table('interested')->truncate();
    $start = microtime(true);
    $chunkSize = 2500;

    $where = [
      'campaign_result' => 1,
      'connect_response_by_cs' => 1,
    ];
    $idDUmp = [];
    MasterNumbers::where($where)->chunkById($chunkSize, function($chunksMaster) use(&$idDUmp){
      foreach($chunksMaster as $key => $v){
        $data = [
            'master_numbers_id' => $v->id,
            'category_web' => $v->category_web, 
            'category_game' => $v->category_game,
        ];
        $dataInsert[] = $data;
        $idDUmp[] = $v->id;
      }
      \DB::table('interested')->insert($dataInsert);
      unset($dataInsert);
    });

    $time = microtime(true) - $start;
    if($bot == FALSE){
      return redirect('/devtools/database')->with('success', "Interested insert successfully. Execution time : $time");
    }else{
      return [
        'type' => TRUE,
        'time' => $time,
        'id' => $idDUmp,
      ];
    }
  }

  public function step_5($bot = FALSE)//check
  {
    // must include (server option)
    DB::disableQueryLog();
    ini_set("memory_limit",'-1');
    ini_set('max_execution_time', 3000);
    ini_set('auto_detect_line_endings', true);
    DB::table('check')->truncate();
    $start = microtime(true);
    $chunkSize = 2500;

    // $where = [
    //   'is_assigned' => 1,
    //   'is_contacted' => 1,
    // ];
    $idDUmp = [];
    MasterNumbers::where('campaign_result', '=', 0)->orWhereNull('campaign_result')->whereNotNull('connect_response_by_cs')->chunkById($chunkSize, function($chunksMaster) use(&$idDUmp){
      foreach($chunksMaster as $key => $v){
        $data = [
            'master_numbers_id' => $v->id,
            'category_web' => $v->category_web, 
            'category_game' => $v->category_game,
        ];
        $dataInsert[] = $data;
        $idDUmp[] = $v->id;
      }
      \DB::table('check')->insert($dataInsert);
      unset($dataInsert);
    });

    $time = microtime(true) - $start;
    if($bot == FALSE){
      return redirect('/devtools/database')->with('success', "Check insert successfully. Execution time : $time");
    }else{
      return [
        'type' => TRUE,
        'time' => $time,
        'id' => $idDUmp,
      ];
    }
  }

  public function bot_step()
  {
    $response = [
      'type' => 'error',
      'message' => 'There error process',
    ];
    $arrayId = [];
    $totalTime = 0;
    $time1 = $this->step_1(TRUE);
    if($time1['type'] == TRUE){
      $totalTime = $totalTime + $time1['time'];
      $time2 = $this->step_2(TRUE);
      if($time2['type'] == TRUE){
        $totalTime = $totalTime + $time2['time'];
        $time3 = $this->step_3(TRUE);
        if($time3['type'] == TRUE){
          $totalTime = $totalTime + $time3['time'];
          $time4 = $this->step_4(TRUE);
          if($time4['type'] == TRUE){
            $totalTime = $totalTime + $time4['time'];
            $time5 = $this->step_5(TRUE);
            if($time5['type'] == TRUE){
              $totalTime = $totalTime + $time5['time'];
              $response = [
                'type' => 'success',
                'message' => "All step successfully. Execution time : $totalTime",
              ];
            }
          }
        }
      }
    }
    $arrayId[] = $time1['id'];
    $arrayId[] = $time2['id'];
    $arrayId[] = $time3['id'];
    $arrayId[] = $time4['id'];
    $arrayId[] = $time5['id'];
    $arrayIdBucket = [];
    // dd(array_values(array_values($arrayId)));
    foreach($arrayId as $id){
      foreach($id as $key => $v){
        $arrayIdBucket[] = $v;
      }
    }
    // $array = array_values($arrayIdBucket);
    // dd($array);
    // reactive this if need
    // $query = \DB::table('master_numbers')->whereNotIn('id', $arrayIdBucket)->get();
    // var_dump($query);die;
    return redirect('/devtools/database')->with($response['type'], $response['message']);
  }

  // child database
  public function truncate($type = NULL)
  {
    $response = [
      'type' => 'error',
      'message' => 'OOppp!! something wrong',
    ];
    if($type == NULL){// truncate all
      DB::table('index_master_numbers')->truncate();
      DB::table('master_numbers_new')->truncate();
      DB::table('new_numbers')->truncate();
      DB::table('assigned')->truncate();
      DB::table('contacted')->truncate();
      DB::table('interested')->truncate();
      DB::table('registered')->truncate();
      DB::table('check')->truncate();
      DB::table('reassign')->truncate();
      DB::table('players')->truncate();
      DB::table('trash')->truncate();
      $response = [
        'type' => 'success',
        'message' => 'Successfully truncate all table.',
      ];
    }elseif($type == 1){// truncate new numbers
      DB::table('new_numbers')->truncate();
      $response = [
        'type' => 'success',
        'message' => 'Successfully truncate new_numbers table.',
      ];
    }elseif($type == 2){// truncate assigned
      DB::table('assigned')->truncate();
      DB::table('new_numbers')->truncate();
      $response = [
        'type' => 'success',
        'message' => 'Successfully truncate assigned table.',
      ];
    }elseif($type == 3){// truncate contacted
      DB::table('contacted')->truncate();
      $response = [
        'type' => 'success',
        'message' => 'Successfully truncate contacted table.',
      ];
    }elseif($type == 4){// truncate interested
      DB::table('interested')->truncate();
      $response = [
        'type' => 'success',
        'message' => 'Successfully truncate interested table.',
      ];
    }elseif($type == 5){// truncate registered
      DB::table('registered')->truncate();
      $response = [
        'type' => 'success',
        'message' => 'Successfully truncate registered table.',
      ];
    }elseif($type == 6){// truncate check
      DB::table('check')->truncate();
      $response = [
        'type' => 'success',
        'message' => 'Successfully truncate check table.',
      ];
    }elseif($type == 7){// truncate reassign
      DB::table('reassign')->truncate();
      $response = [
        'type' => 'success',
        'message' => 'Successfully truncate reassign table.',
      ];
    }elseif($type == 8){// truncate players
      DB::table('players')->truncate();
      $response = [
        'type' => 'success',
        'message' => 'Successfully truncate players table.',
      ];
    }elseif($type == 9){// truncate trash
      DB::table('trash')->truncate();
      $response = [
        'type' => 'success',
        'message' => 'Successfully truncate trash table.',
      ];
    }elseif($type == 10){// truncate all kurcaci
      DB::table('new_numbers')->truncate();
      DB::table('assigned')->truncate();
      DB::table('contacted')->truncate();
      DB::table('interested')->truncate();
      DB::table('registered')->truncate();
      DB::table('check')->truncate();
      DB::table('reassign')->truncate();
      DB::table('players')->truncate();
      DB::table('trash')->truncate();
      $response = [
        'type' => 'success',
        'message' => 'Successfully truncate all kurcaci table.',
      ];
    }
    Session::put($response['type'], $response['message']);
    return redirect('/devtools/database');
  }

  // truncate new numbers
  public function truncate_newnumbers()
  {
    DB::table('new_numbers')->truncate();
    Session::put('success', 'Successfully truncate database.');
    return redirect('/devtools/database');
  }

  public function cache_flush()
  {
    Cache::flush();
    $response = [
      'type' => 'success',
      'message' => 'Successfully flush cache.',
    ];
    Session::put($response['type'], $response['message']);
    return redirect('/devtools/database');
  }
}
