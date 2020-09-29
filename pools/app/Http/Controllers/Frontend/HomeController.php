<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Orchardpools;
use App\Models\Seo;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

// luffy 12 april 2020 05:19 pm
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class HomeController extends Controller
{
  private $settings;

  public function __construct()
  {
    $this->settings = DB::table('orchardpools_settings')->first();
    date_default_timezone_set($this->settings->timezone);
    // ------------------------------------- Number ------------------------------------- //
    $countdownStop = $this->settings->countdown_stop;
    $this->settings->countdown_stop_full = date("Y-m-d $countdownStop");
    // get diff time consolation 6 to consolation 5
    $diff = $this->getDiffMinuteTime();
    // get diff time consolation 6 to winner 1
    $diffStartx = $this->getDiffMinuteTime('orchardpools_consolation', 6, 'orchardpools_winner', 1);
    // prepare time stop + consolation 6 to winner 1 diff time
    $countdownStopX = date('H:i:s', strtotime("+$diffStartx minutes", strtotime($countdownStop)));
    //  put into private variable
    $this->settings->countdown_stopx = date("Y-m-d $countdownStopX");

    // luffy 14 may 2020 12:47 pm
    // get timeshow only from the latest winner number.
    $timeShowWinner1 = DB::table('orchardpools_winner')->where('prize', '=', 1)->orderBy('id', 'desc')->pluck('time_show')->first();
    $this->settings->timeShowWinner1 = $timeShowWinner1;

    // add diff time consolation 6 -5 into variable
    $countdownStartX = date('H:i:s', strtotime("+$diff minutes", strtotime($countdownStop)));
    // put countdown start into private variable
    $this->settings->countdown_start = date("Y-m-d $countdownStartX");
    // get countdown start from private variable
    $countdownStart = $this->settings->countdown_start;
    // 
    if (strtotime(date('H:i:s')) < strtotime($countdownStop)) {
      $this->countdownTime = date("Y-m-d $countdownStop");
    }else{
      $this->countdownTime = date("Y-m-d $countdownStop", strtotime('+24 hours'));
    }
    if(strtotime(date('Y-m-d H:i:s')) >= strtotime(date("Y-m-d $countdownStop")) && strtotime(date('Y-m-d H:i:s')) <= strtotime(date("Y-m-d $countdownStart"))){
      $this->settings->countdown_status = FALSE;
    }else{
      $this->settings->countdown_status = TRUE;
    }
    // get 10 draw before countdown stop
    // if(strtotime(date('Y-m-d H:i:s')) >= strtotime($this->settings->countdown_stopx)){
    // luffy fixing 14 may 2020 12:47 pm
    if(strtotime(date('Y-m-d H:i:s')) >= strtotime($this->settings->timeShowWinner1)){
      $draw = DB::table('orchardpools_draw')->where('date_for_number', '<=', date('Y-m-d',strtotime($this->settings->timeShowWinner1)))->orderBy('id', 'desc')->limit(10)->get();
    }else{
      $draw = DB::table('orchardpools_draw')->where('date_for_number', '<', date('Y-m-d',strtotime($this->settings->timeShowWinner1)))->orderBy('id', 'desc')->limit(10)->get();
    }
    if(count($draw) > 0){
      foreach($draw as $value){
        $this->settings->lastWinner10[] = DB::table('orchardpools_winner as winner')->leftJoin('orchardpools_draw as draw', 'draw.id', 'winner.draw_id')->select('winner.number', 'draw.date_for_number')->where('winner.draw_id', $value->id)->where('prize', 1)->orderBy('draw.id', 'desc')->first();
      }
      $this->settings->lastWinner = $this->settings->lastWinner10[0];
    }else{
      $this->settings->lastWinner = [];
      $this->settings->lastWinner10 = [];
    }
    // ------------------------------------- script ------------------------------------- //
    $scriptsHead = DB::table('orchardpools_scripts')->where('active', 1)->orderBy('priority', 'asc')->get();
    if(count($scriptsHead)){
      $this->settings->arrScriptsHead = DB::table('orchardpools_scripts')->where('active', 1)->orderBy('priority', 'asc')->get();
    }else{
      $this->settings->arrScriptsHead = [];
    }
    // ------------------------------------- logo ------------------------------------- //
    $this->settings->logos = [
      'logo' => $this->settings->logo,
      'height' => $this->settings->logo_height,
      'width' => $this->settings->logo_width,
    ];
    // ------------------------------------- social media ------------------------------------- //
    $this->settings->socials = DB::table('orchardpools_socials')->orderBy('id', 'asc')->get();
    // ------------------------------------- footer ------------------------------------- //
    $this->settings->footers = DB::table('orchardpools_footer')->orderBy('id', 'asc')->get();
  }
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // SEO things di sini...
    $seo = Seo::where('menu_name', 'home')->first();
    filter_var($seo->url, FILTER_VALIDATE_URL) ? $imageUrl = parse_url($seo->url) : $imageUrl['host'] = '' ;
    SEOMeta::setTitle($seo->title);
    SEOMeta::addKeyword(explode(',', $seo->keyword));
    SEOMeta::setDescription($seo->description);
    SEOMeta::setCanonical($seo->canonical);
    OpenGraph::setTitle($seo->title);
    OpenGraph::setDescription($seo->description);
    OpenGraph::setUrl($seo->url);
    OpenGraph::addProperty('type', $seo->property);
    OpenGraph::addImage('http://'.$imageUrl['host'].'/public/upload/'.$this->settings->logo, ['height' => 300, 'width' => 300, 'type' => 'image/jpeg', 'secure_url' => 'https://'.$imageUrl['host'].'/public/upload/'.$this->settings->logo]);
    
    // Date now
    $date = date('Y-m-d H:i:s');
    // array contain countdown settings
    $configCountdown = [
      'countdown_stop' => $this->countdownTime,
      'countdown_stop_full' => $this->settings->countdown_stop_full,
      'countdown_status' => $this->settings->countdown_status,
      'countdown_start' => $this->settings->countdown_start,
      'countdown_stopx' => $this->settings->countdown_stopx,
    ];
    // prevant error variable
    $dataNumber = [];
    // if(strtotime(date('Y-m-d H:i:s')) >= strtotime($this->settings->countdown_stopx)){
    // luffy fixing 14 may 2020 12:47 pm
    if(strtotime(date('Y-m-d H:i:s')) >= strtotime($this->settings->timeShowWinner1)){
      $allDraw = DB::table('orchardpools_draw')->where('date_for_number', '<=', date('Y-m-d',strtotime($this->settings->timeShowWinner1)))->orderBy('id', 'desc')->limit(3)->get();
    }else{
      $allDraw = DB::table('orchardpools_draw')->where('date_for_number', '<', date('Y-m-d',strtotime($this->settings->timeShowWinner1)))->orderBy('id', 'desc')->limit(3)->get();
    }
    if(count($allDraw) > 0){
      foreach($allDraw as $value){
        $dataNumber[] = [
          'date_for_number' => $value->date_for_number,
          'winner' => DB::table('orchardpools_winner')->where('draw_id', $value->id)->get(),
          'starter' => DB::table('orchardpools_starter')->where('draw_id', $value->id)->get(),
          'consolation' => DB::table('orchardpools_consolation')->where('draw_id', $value->id)->get(),
        ];
      }
    }
    $lastWinner = $this->settings->lastWinner;
    $lastWinner10 = $this->settings->lastWinner10;
    // $body_bottom_columns = $seo = Seo::where('menu_name', 'home')->first();
    // logo
    $logo = $this->settings->logos;
    // background
    $background = $this->settings->background;
    // script head
    $arrScriptsHead = $this->settings->arrScriptsHead;
    // popup
    $popup = [
      'status' => $this->settings->popup_status,
      'title' => $this->settings->popup_title,
      'content' => $this->settings->popup_content,
      'timeout' => $this->settings->popup_timeout,
    ];
    // social media
    $socials = $this->settings->socials;
    $settings = $this->settings;
    $footers = $this->settings->footers;
    $footer_description = Seo::where('menu_name', 'home')->first()->description;
    return view('frontend.home', compact('dataNumber', 'seo', 'date', 'lastWinner', 'configCountdown', 'lastWinner10', 'logo','background','arrScriptsHead','popup','socials', 'settings', 'footers', 'footer_description'));
  }

  public function result()
  {
    // SEO things di sini...
    $seo = Seo::where('menu_name', 'result')->first();
    filter_var($seo->url, FILTER_VALIDATE_URL) ? $imageUrl = parse_url($seo->url) : $imageUrl['host'] = '' ;
    SEOMeta::setTitle($seo->title);
    SEOMeta::addKeyword(explode(',', $seo->keyword));
    SEOMeta::setDescription($seo->description);
    SEOMeta::setCanonical($seo->canonical);
    OpenGraph::setTitle($seo->title);
    OpenGraph::setDescription($seo->description);
    OpenGraph::setUrl($seo->url);
    OpenGraph::addProperty('type', $seo->property);
    OpenGraph::addImage('http://'.$imageUrl['host'].'/public/upload/'.$this->settings->logo, ['height' => 300, 'width' => 300, 'type' => 'image/jpeg', 'secure_url' => 'https://'.$imageUrl['host'].'/public/upload/'.$this->settings->logo]);

    // Date now
    $date = date('Y-m-d H:i:s');
    // array contain countdown settings
    $configCountdown = [
      'countdown_stop' => $this->countdownTime,
      'countdown_status' => $this->settings->countdown_status,
    ];
    // prevant error variable
    $dataNumber = [];
    $allDraw = [];

    // if(strtotime(date('Y-m-d H:i:s')) >= strtotime($this->settings->countdown_stopx)){
    // luffy fixing 14 may 2020 12:47 pm
    if(strtotime(date('Y-m-d H:i:s')) >= strtotime($this->settings->timeShowWinner1)){
      $allDraw = DB::table('orchardpools_draw')->where('date_for_number', '<=', date('Y-m-d',strtotime($this->settings->timeShowWinner1)))->orderBy('date_for_number', 'desc')->paginate(6);
    }else{
      $allDraw = DB::table('orchardpools_draw')->where('date_for_number', '<', date('Y-m-d',strtotime($this->settings->timeShowWinner1)))->orderBy('date_for_number', 'desc')->paginate(6);
    }

    // if(DB::table('orchardpools_draw')->where('date_for_number', '<=', date('Y-m-d'))->count() > 0){
    //   if(strtotime(date('Y-m-d H:i:s')) >= strtotime(date("Y-m-d ".$this->settings->countdown_stop))){
    //     $allDraw = DB::table('orchardpools_draw')->where('date_for_number', '<=', date('Y-m-d'))->orderBy('id', 'desc')->paginate(9);
    //   }else{
    //     $allDraw = DB::table('orchardpools_draw')->where('date_for_number', '<', date('Y-m-d'))->orderBy('id', 'desc')->paginate(9);
    //   }
    foreach($allDraw as $value){
      $dataNumber[] = [
        'date_for_number' => $value->date_for_number,
        'winner' => DB::table('orchardpools_winner')->where('draw_id', $value->id)->get(),
        'starter' => DB::table('orchardpools_starter')->where('draw_id', $value->id)->get(),
        'consolation' => DB::table('orchardpools_consolation')->where('draw_id', $value->id)->get(),
      ];
    }
    // }

    $lastWinner = $this->settings->lastWinner;
    $lastWinner10 = $this->settings->lastWinner10;
    // $body_bottom_columns = $seo = Seo::where('menu_name', 'home')->first();
    // logo
    $logo = $this->settings->logos;
    // background
    $background = $this->settings->background;
    $arrScriptsHead = $this->settings->arrScriptsHead;
    // social media
    $socials = $this->settings->socials;
    $settings = $this->settings;
    $footers = $this->settings->footers;
    $footer_description = Seo::where('menu_name', 'home')->first()->description;
    return view('frontend.result', compact('dataNumber', 'allDraw', 'date', 'configCountdown','lastWinner','lastWinner10','logo','background','arrScriptsHead','socials','settings','footers','seo','footer_description'));
  }

  public function livedraw()
  {
    // SEO things di sini...
    $seo = Seo::where('menu_name', 'livedraw')->first();
    filter_var($seo->url, FILTER_VALIDATE_URL) ? $imageUrl = parse_url($seo->url) : $imageUrl['host'] = '' ;
    SEOMeta::setTitle($seo->title);
    SEOMeta::addKeyword(explode(',', $seo->keyword));
    SEOMeta::setDescription($seo->description);
    SEOMeta::setCanonical($seo->canonical);
    OpenGraph::setTitle($seo->title);
    OpenGraph::setDescription($seo->description);
    OpenGraph::setUrl($seo->url);
    OpenGraph::addProperty('type', $seo->property);
    OpenGraph::addImage('http://'.$imageUrl['host'].'/public/upload/'.$this->settings->logo, ['height' => 300, 'width' => 300, 'type' => 'image/jpeg', 'secure_url' => 'https://'.$imageUrl['host'].'/public/upload/'.$this->settings->logo]);
    // Date now
    $date = date('Y-m-d H:i:s');
    
    // countdown config
    $configCountdown = [      
      'countdown_stop' => $this->countdownTime,
      'countdown_stop_full' => $this->settings->countdown_stop_full,
      'countdown_status' => $this->settings->countdown_status,
      'countdown_start' => $this->settings->countdown_start,
      'countdown_stopx' => $this->settings->countdown_stopx,
    ];
    // dd($configCountdown);
    // prevant error variable
    $liveNumber = [];
    // if(strtotime(date('Y-m-d H:i:s')) > strtotime($this->settings->countdown_stopx)){
    //   $liveDraw = DB::table('orchardpools_draw')->whereDate('date_for_number', '=', date('Y-m-d', strtotime('+1 days')))->first();
    // }else{ 
    //   // $liveDraw = DB::table('orchardpools_draw')->whereDate('date_for_number', '=', date('Y-m-d'))->first();
    //   if(strtotime(date('Y-m-d H:i:s')) > strtotime(date('Y-m-d '.$this->settings->countdown_stop)) && strtotime(date('Y-m-d H:i:s')) < strtotime($this->settings->countdown_stopx)){
    //     $liveDraw = DB::table('orchardpools_draw')->whereDate('date_for_number', '=', date('Y-m-d'))->first();
    //   }else{
    //     $liveDraw = FALSE;
    //   }
    // }

    // by default
    $liveDraw = DB::table('orchardpools_draw')->where('date_for_number', '<', date('Y-m-d'))->orderBy('id', 'desc')->first();
    // but if now > countdown_stop time
    if(strtotime(date('Y-m-d H:i:s')) > strtotime($this->settings->countdown_stop_full)){
      $liveDraw = DB::table('orchardpools_draw')->whereDate('date_for_number', '=', date('Y-m-d'))->first();
    }
    // elseif(strtotime(date('Y-m-d H:i:s')) < strtotime($this->settings->countdown_stop_full)){
    //   // $liveDraw = DB::table('orchardpools_draw')->whereDate('date_for_number', '=', date('Y-m-d', strtotime('-1 days')))->first();
    // }else{
    //   $liveDraw = FALSE;
    // }
    if($liveDraw){
      $liveNumber = [
        'winner' => DB::table('orchardpools_winner')->where('draw_id', $liveDraw->id)->get(),
        'starter' => DB::table('orchardpools_starter')->where('draw_id', $liveDraw->id)->get(),
        'consolation' => DB::table('orchardpools_consolation')->where('draw_id', $liveDraw->id)->get(),
      ];
    }
    $lastWinner = $this->settings->lastWinner;
    $lastWinner10 = $this->settings->lastWinner10;
    // $body_bottom_columns = $seo = Seo::where('menu_name', 'home')->first();
    // logo
    $logo = $this->settings->logos;
    // background
    $background = $this->settings->background;
    $arrScriptsHead = $this->settings->arrScriptsHead;
    // social media
    $socials = $this->settings->socials;
    $settings = $this->settings;
    $footers = $this->settings->footers;
    $footer_description = Seo::where('menu_name', 'home')->first()->description;
    return view('frontend.livedraw', compact('settings','liveNumber','lastWinner','lastWinner10','configCountdown','date','logo','background', 'arrScriptsHead','socials','footers','seo','footer_description'));
  }

  public function about()
  {
    // SEO things di sini...
    $seo = Seo::where('menu_name', 'about')->first();
    filter_var($seo->url, FILTER_VALIDATE_URL) ? $imageUrl = parse_url($seo->url) : $imageUrl['host'] = '' ;
    SEOMeta::setTitle($seo->title);
    SEOMeta::addKeyword(explode(',', $seo->keyword));
    SEOMeta::setDescription($seo->description);
    SEOMeta::setCanonical($seo->canonical);
    OpenGraph::setTitle($seo->title);
    OpenGraph::setDescription($seo->description);
    OpenGraph::setUrl($seo->url);
    OpenGraph::addProperty('type', $seo->property);
    OpenGraph::addImage('http://'.$imageUrl['host'].'/public/upload/'.$this->settings->logo, ['height' => 300, 'width' => 300, 'type' => 'image/jpeg', 'secure_url' => 'https://'.$imageUrl['host'].'/public/upload/'.$this->settings->logo]);

    // Date now
    $date = date('Y-m-d H:i:s');
    // countdown config
    $configCountdown = [
      'countdown_stop' => $this->countdownTime,
      'countdown_status' => $this->settings->countdown_status,
    ];
    $lastWinner = $this->settings->lastWinner;
    $lastWinner10 = $this->settings->lastWinner10;
    // logo
    $logo = $this->settings->logos;
    // background
    $background = $this->settings->background;
    $arrScriptsHead = $this->settings->arrScriptsHead;
    // social media
    $socials = $this->settings->socials;
    $settings = $this->settings;
    $footers = $this->settings->footers;
    $footer_description = Seo::where('menu_name', 'home')->first()->description;
    return view('frontend.about', compact('settings','lastWinner','lastWinner10','configCountdown','date','seo', 'logo','background','arrScriptsHead','socials','footers','footer_description'));
  }

  public function contact()
  {
    // SEO things di sini...
    $seo = Seo::where('menu_name', 'contact')->first();
    filter_var($seo->url, FILTER_VALIDATE_URL) ? $imageUrl = parse_url($seo->url) : $imageUrl['host'] = '' ;
    SEOMeta::setTitle($seo->title);
    SEOMeta::addKeyword(explode(',', $seo->keyword));
    SEOMeta::setDescription($seo->description);
    SEOMeta::setCanonical($seo->canonical);
    OpenGraph::setTitle($seo->title);
    OpenGraph::setDescription($seo->description);
    OpenGraph::setUrl($seo->url);
    OpenGraph::addProperty('type', $seo->property);
    OpenGraph::addImage('http://'.$imageUrl['host'].'/public/upload/'.$this->settings->logo, ['height' => 300, 'width' => 300, 'type' => 'image/jpeg', 'secure_url' => 'https://'.$imageUrl['host'].'/public/upload/'.$this->settings->logo]);

    // Date now
    $date = date('Y-m-d H:i:s');
    // countdown config
    $configCountdown = [
      'countdown_stop' => $this->countdownTime,
      'countdown_status' => $this->settings->countdown_status,
    ];
    $lastWinner = $this->settings->lastWinner;
    $lastWinner10 = $this->settings->lastWinner10;
    // logo
    $logo = $this->settings->logos;
    // background
    $background = $this->settings->background;
    $arrScriptsHead = $this->settings->arrScriptsHead;
    // social media
    $socials = $this->settings->socials;
    $settings = $this->settings;
    $footers = $this->settings->footers;
    $footer_description = Seo::where('menu_name', 'home')->first()->description;
    return view('frontend.contact', compact('settings','lastWinner','lastWinner10','configCountdown','date','seo', 'logo','background', 'arrScriptsHead','socials','footers','footer_description'));
  }

  private function getDiffMinuteTime($table1 = 'orchardpools_consolation', $prize1 = 6, $table2 = 'orchardpools_consolation', $prize2 = 5)
  {
    $check = DB::table($table1)->whereDate('created_at', date('Y-m-d'))->where('prize', $prize1)->count();
    if($check > 0){
      $first = DB::table($table1)->whereDate('created_at', date('Y-m-d'))->where('prize', $prize1)->first()->time_show;
      $last = DB::table($table2)->whereDate('created_at', date('Y-m-d'))->where('prize', $prize2)->first()->time_show;
      if(empty($first) && empty($last)){
        $draw_no = DB::table('orchardpools_draw')->max('id');
        $first = DB::table($table1)->where('draw_id', $draw_no)->where('prize', $prize1)->first()->time_show;
        $last = DB::table($table2)->where('draw_id', $draw_no)->where('prize', $prize2)->first()->time_show;
      }
      $now = new \DateTime($last);
      $then = new \DateTime($first);
      $diff = $now->diff($then)->format('%i');
      return $diff;
    }else{
      return FALSE;
    }
  }
}
