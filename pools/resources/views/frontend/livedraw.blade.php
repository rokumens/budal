@extends('frontend.layouts.app')

@php
  // time now in strtotime 
  $strNow = strtotime(date('Y-m-d H:i:s'));
  // countdown start in strtotime
  $strCountStart = strtotime($configCountdown['countdown_start']);
  // countdown stop H:i:s in strtotime
  $strCountStop = strtotime($configCountdown['countdown_stop']);
  // countdown stop Y-m-d H:i:s in strtotime
  $strCountStopFull = strtotime($configCountdown['countdown_stop_full']);
  // countdown stop Y-m-d H:i:s + consolation 6 to winner 1 time in strtotime
  $strCountStopx = strtotime($configCountdown['countdown_stopx']);
  // refresh timeout if countdown hits 0
  $refreshCount = $strCountStop - $strNow;

  if($liveNumber){
    // put timeout winner into array
    foreach($liveNumber['winner'] as $value){
      $dataWinner[$value->prize] = strtotime($value->time_show) - strtotime(date('Y-m-d H:i:s'));
    }
    // put timeout starter into array
    foreach($liveNumber['starter'] as $value){
      $dataStarter[$value->prize] = strtotime($value->time_show) - strtotime(date('Y-m-d H:i:s'));
    }
    // put timeout consolation into array
    foreach($liveNumber['consolation'] as $value){
      $dataConsolation[$value->prize] = strtotime($value->time_show) - strtotime(date('Y-m-d H:i:s'));
    }
  }
@endphp

@section('head_css')
<meta http-equiv="refresh" content="{{ $refreshCount }}">
<style>
  section.section-single {
    background-image: url('{{ asset("public/upload/$background") }}');
  }
  .custom-content h1, h2, h3, h4, h5 {
    color: #151515 !important;
  }
</style>
@endsection

@section('contents')
<div class="page">
  <!-- Page content-->
  <section class="section section-single bg-image-dark">
    <div class="section-single-inner">
      <div class="section-single-main">
        <div class="container mt-5">
          <h3>Next Draw in :</h3>
          <div class="divider-small"></div>
          <div class="countdown-box">
            @if($configCountdown['countdown_status'] == TRUE)
            <div class="countdown-circle-container" data-countdown="data-countdown" data-to="{{ $configCountdown['countdown_stop'] }}">
              <div class="countdown-block countdown-block-hours">
                <svg class="countdown-circle" x="0" y="0" width="170" height="170" viewBox="0 0 170 170" data-progress-hours="">
                  <circle class="countdown-circle-bg" cx="85" cy="85" r="83"></circle>
                  <circle class="countdown-circle-fg clipped" cx="85" cy="85" r="83" clip-path="url(#mmwqrybn)"></circle>
                <clipPath id="mmwqrybn"><path d="M 85 85 L 85 -37.39999999999999 A 122.39999999999999 122.39999999999999 0 0 1 85 207.39999999999998 A 122.39999999999999 122.39999999999999 0 0 1 12.36231145616975 183.51662906844462"></path></clipPath></svg>
                <div class="countdown-wrap">
                  <div class="countdown-counter" data-counter-hours="">14</div>
                  <div class="countdown-title">hours</div>
                </div>
              </div>
              <div class="countdown-block countdown-block-minutes">
                <svg class="countdown-circle" x="0" y="0" width="170" height="170" viewBox="0 0 170 170" data-progress-minutes="">
                  <circle class="countdown-circle-bg" cx="85" cy="85" r="83"></circle>
                  <circle class="countdown-circle-fg clipped" cx="85" cy="85" r="83" clip-path="url(#hpwqqsfw)"></circle>
                <clipPath id="hpwqqsfw"><path d="M 85 85 L 85 -37.39999999999999 A 122.39999999999999 122.39999999999999 0 0 1 139.33741335793968 194.6777347941158"></path></clipPath></svg>
                <div class="countdown-wrap">
                  <div class="countdown-counter" data-counter-minutes="">25</div>
                  <div class="countdown-title">minutes</div>
                </div>
              </div>
              <div class="countdown-block countdown-block-seconds">
                <svg class="countdown-circle" x="0" y="0" width="170" height="170" viewBox="0 0 170 170" data-progress-seconds="">
                  <circle class="countdown-circle-bg" cx="85" cy="85" r="83"></circle>
                  <circle class="countdown-circle-fg clipped" cx="85" cy="85" r="83" clip-path="url(#mccewkux)"></circle>
                <clipPath id="mccewkux"><path d="M 85 85 L 85 -37.39999999999999 A 122.39999999999999 122.39999999999999 0 0 1 85 207.39999999999998 A 122.39999999999999 122.39999999999999 0 0 1 8.480302605404546 180.53269550598654"></path></clipPath></svg>
                <div class="countdown-wrap">
                  <div class="countdown-counter" data-counter-seconds="">36</div>
                  <div class="countdown-title">seconds</div>
                </div>
              </div>
            </div>
            @else
            <div class="countdown-circle-container" data-countdown="data-countdown" data-to="0000-00-00">
              <div class="countdown-block countdown-block-days">
                <svg class="countdown-circle" x="0" y="0" width="170" height="170" viewBox="0 0 170 170" data-progress-days="">
                  <circle class="countdown-circle-bg" cx="85" cy="85" r="83"></circle>
                  <circle class="countdown-circle-fg clipped" cx="85" cy="85" r="83" clip-path="url(#ofmdgvmj)"></circle>
                <clipPath id="ofmdgvmj"><path d="M 85 85 L 85 -37.39999999999999 A 122.39999999999999 122.39999999999999 0 0 1 85 207.39999999999998 A 122.39999999999999 122.39999999999999 0 0 1 -25.570750204541326 137.49637320048805"></path></clipPath></svg>
                <div class="countdown-wrap">
                  <div class="countdown-counter" data-counter-days="">248</div>
                  <div class="countdown-title">days</div>
                </div>
              </div>
              <div class="countdown-block countdown-block-hours">
                <svg class="countdown-circle" x="0" y="0" width="170" height="170" viewBox="0 0 170 170" data-progress-hours="">
                  <circle class="countdown-circle-bg" cx="85" cy="85" r="83"></circle>
                  <circle class="countdown-circle-fg clipped" cx="85" cy="85" r="83" clip-path="url(#mmwqrybn)"></circle>
                <clipPath id="mmwqrybn"><path d="M 85 85 L 85 -37.39999999999999 A 122.39999999999999 122.39999999999999 0 0 1 85 207.39999999999998 A 122.39999999999999 122.39999999999999 0 0 1 12.36231145616975 183.51662906844462"></path></clipPath></svg>
                <div class="countdown-wrap">
                  <div class="countdown-counter" data-counter-hours="">14</div>
                  <div class="countdown-title">hours</div>
                </div>
              </div>
              <div class="countdown-block countdown-block-minutes">
                <svg class="countdown-circle" x="0" y="0" width="170" height="170" viewBox="0 0 170 170" data-progress-minutes="">
                  <circle class="countdown-circle-bg" cx="85" cy="85" r="83"></circle>
                  <circle class="countdown-circle-fg clipped" cx="85" cy="85" r="83" clip-path="url(#hpwqqsfw)"></circle>
                <clipPath id="hpwqqsfw"><path d="M 85 85 L 85 -37.39999999999999 A 122.39999999999999 122.39999999999999 0 0 1 139.33741335793968 194.6777347941158"></path></clipPath></svg>
                <div class="countdown-wrap">
                  <div class="countdown-counter" data-counter-minutes="">25</div>
                  <div class="countdown-title">minutes</div>
                </div>
              </div>
              <div class="countdown-block countdown-block-seconds">
                <svg class="countdown-circle" x="0" y="0" width="170" height="170" viewBox="0 0 170 170" data-progress-seconds="">
                  <circle class="countdown-circle-bg" cx="85" cy="85" r="83"></circle>
                  <circle class="countdown-circle-fg clipped" cx="85" cy="85" r="83" clip-path="url(#mccewkux)"></circle>
                <clipPath id="mccewkux"><path d="M 85 85 L 85 -37.39999999999999 A 122.39999999999999 122.39999999999999 0 0 1 85 207.39999999999998 A 122.39999999999999 122.39999999999999 0 0 1 8.480302605404546 180.53269550598654"></path></clipPath></svg>
                <div class="countdown-wrap">
                  <div class="countdown-counter" data-counter-seconds="">36</div>
                  <div class="countdown-title">seconds</div>
                </div>
              </div>
            </div>
            @endif
          </div>

          <div class="row">
            <div class="col-12">

            @if(count($liveNumber) > 0)

            <article class="card card-custom p-0 mb-3 rounded" style="background-color: rgba(42, 52, 61, .88);">
              <div class="card-header" id="accordion1Heading1" role="tab">
                <div class="card-standing-team-item">
                  <div class="card-standing-team">
                    <div class="card-standing-team-title">
                      <div class="card-standing-team-name">Prize</div>
                    </div>
                  </div>
                  @if(strtotime(date('Y-m-d H:i:s')) > strtotime($configCountdown['countdown_stop_full']))
                    @foreach($liveNumber['winner'] as $value)
                      <div class="card-standing-diff winner{{ $value->prize }} prizeBox my-auto">
                        @if(strtotime(date('Y-m-d H:i:s')) <= strtotime($value->time_show))
                        <div class="d-flex align-items-center text-white">
                          <div class="spinner-border spinner-border-sm ml-auto" role="status" aria-hidden="true"></div>
                        </div>
                        @else
                        @php
                            $title = '';
                            if($value->prize == 1){
                              $title = "1st";
                            }elseif($value->prize == 2){
                              $title = "2nd";
                            }else{
                              $title = "3rd";
                            }
                        @endphp
                        <div class="team-title">
                          <div class="team-name">{{ $value->number }}</div>
                          <div class="team-country">{{$title}}</div>
                        </div>
                        @endif
                      </div>
                    @endforeach
                  @else
                    @foreach($liveNumber['winner'] as $value)
                      <div class="card-standing-diff value{{ $value->prize }} prizeBox my-auto">
                        @php
                          $title = '';
                          if($value->prize == 1){
                            $title = "1st";
                          }elseif($value->prize == 2){
                            $title = "2nd";
                          }else{
                            $title = "3rd";
                          }
                        @endphp
                        <div class="team-title">
                          <div class="team-name">{{ $value->number }}</div>
                          <div class="team-country">{{$title}}</div>
                        </div>
                      </div>
                    @endforeach
                  @endif
                </div>
              </div>
            </article>

            <article class="card card-custom p-0 mb-3" style="background-color: rgba(42, 52, 61, .88);">
              <div class="card-header" id="accordion1Heading1" role="tab">
                <div class="card-standing-team-item">
                  <div class="card-standing-team">
                    <div class="card-standing-team-title">
                      <div class="card-standing-team-name">Starter</div>
                    </div>
                  </div>
                  @if(strtotime(date('Y-m-d H:i:s')) > strtotime($configCountdown['countdown_stop_full']))
                    @foreach($liveNumber['starter'] as $value)
                      <div class="card-standing-diff starter{{ $value->prize }} prizeBox my-auto">
                        @if(strtotime(date('Y-m-d H:i:s')) <= strtotime($value->time_show))
                        <div class="d-flex align-items-center text-white">
                          <div class="spinner-border spinner-border-sm ml-auto" role="status" aria-hidden="true"></div>
                        </div>
                        @else
                        <div class="team-title">
                          <div class="team-name">{{ $value->number }}</div>
                          <!-- <div class="team-country">Consolation</div> -->
                        </div>
                        @endif
                      </div>
                    @endforeach
                  @else
                    @foreach($liveNumber['starter'] as $value)
                      <div class="card-standing-diff starter{{ $value->prize }} prizeBox my-auto">
                        <div class="team-title">
                          <div class="team-name">{{ $value->number }}</div>
                          <!-- <div class="team-country">Consolation</div> -->
                        </div>
                      </div>
                    @endforeach
                  @endif
                </div>
              </div>
            </article>

            <article class="card card-custom p-0" style="background-color: rgba(42, 52, 61, .88);">
              <div class="card-header" id="accordion1Heading1" role="tab">
                <div class="card-standing-team-item">
                  <div class="card-standing-team">
                    <div class="card-standing-team-title">
                      <div class="card-standing-team-name">Consolation</div>
                    </div>
                  </div>
                  @if(strtotime(date('Y-m-d H:i:s')) > strtotime($configCountdown['countdown_stop_full']))
                    @foreach($liveNumber['consolation'] as $value)
                      <div class="card-standing-diff consolation{{ $value->prize }} prizeBox my-auto">
                        @if(strtotime(date('Y-m-d H:i:s')) <= strtotime($value->time_show))
                        <div class="d-flex align-items-center text-white">
                          <div class="spinner-border spinner-border-sm ml-auto" role="status" aria-hidden="true"></div>
                        </div>
                        @else
                        <div class="team-title">
                          <div class="team-name">{{ $value->number }}</div>
                          <!-- <div class="team-country">Consolation</div> -->
                        </div>
                        @endif
                      </div>
                    @endforeach
                  @else
                    @foreach($liveNumber['consolation'] as $value)
                      <div class="card-standing-diff consolation{{ $value->prize }} prizeBox my-auto">
                        <div class="team-title">
                          <div class="team-name">{{ $value->number }}</div>
                          <!-- <div class="team-country">Consolation</div> -->
                        </div>
                      </div>
                    @endforeach
                  @endif
                </div>
              </div>
            </article>

            @endif

            </div>
          </div>

        </div>
        @if($seo->content != '')
        <div class="container">
          <article class="bg-white text-gray-800 custom-content-lineHeight">
            <div class="p-3 custom-content" style="text-align: initial;">
              {!! $seo->content !!}
            </div>
          </article>
        </div>
        @endif
      </div>
    </div>
  </section>
</div>
@endsection

@section('footer_scripts')
<script>
  $(document).ready(function () {

    // setInterval(function(){ alert("Hello"); }, 3000);

    @if(count($liveNumber) > 0)
    // parsing server time to js variable
    // var nowTime = {{ strtotime(date('Y-m-d H:i:s')) }};
    var nowTime = Date.parse({{ strtotime(date('Y-m-d H:i:s')) }});

    // parsing consolation data get into js variable
    var consolationTime6 = {{ $dataConsolation['6'] }}
    var consolationTime5 = {{ $dataConsolation['5'] }}
    var consolationTime4 = {{ $dataConsolation['4'] }}
    var consolationTime3 = {{ $dataConsolation['3'] }}
    var consolationTime2 = {{ $dataConsolation['2'] }}
    var consolationTime1 = {{ $dataConsolation['1'] }}

    // parsing starter data get into js variable
    var starterTime6 = {{ $dataStarter['6'] }}
    var starterTime5 = {{ $dataStarter['5'] }}
    var starterTime4 = {{ $dataStarter['4'] }}
    var starterTime3 = {{ $dataStarter['3'] }}
    var starterTime2 = {{ $dataStarter['2'] }}
    var starterTime1 = {{ $dataStarter['1'] }}

    // parsing winner data get into js variable
    var winnerTime3 = {{ $dataWinner['3'] }}
    var winnerTime2 = {{ $dataWinner['2'] }}
    var winnerTime1 = {{ $dataWinner['1'] }}

    // debug console check
    console.log(consolationTime6, consolationTime5, consolationTime4, consolationTime3, consolationTime2, consolationTime1, starterTime6, starterTime5, starterTime4, starterTime3, starterTime2, starterTime1, winnerTime3, winnerTime2, winnerTime1);

    // consolation condition time check for ajax function to excute
    if(consolationTime6 > 0){
      ajaxShow('consolation', 6, consolationTime6);
    }
    if(consolationTime5 > 0){
      ajaxShow('consolation', 5, consolationTime5);
    }
    if(consolationTime4 > 0){
      ajaxShow('consolation', 4, consolationTime4);
    }
    if(consolationTime3 > 0){
      ajaxShow('consolation', 3, consolationTime3);
    }
    if(consolationTime2 > 0){
      ajaxShow('consolation', 2, consolationTime2);
    }
    if(consolationTime1 > 0){
      ajaxShow('consolation', 1, consolationTime1);
    }
    // starter condition time check for ajax function to excute
    if(starterTime6 > 0){
      ajaxShow('starter', 6, starterTime6);
    }
    if(starterTime5 > 0){
      ajaxShow('starter', 5, starterTime5);
    }
    if(starterTime4 > 0){
      ajaxShow('starter', 4, starterTime4);
    }
    if(starterTime3 > 0){
      ajaxShow('starter', 3, starterTime3);
    }
    if(starterTime2 > 0){
      ajaxShow('starter', 2, starterTime2);
    }
    if(starterTime1 > 0){
      ajaxShow('starter', 1, starterTime1);
    }
    // winner condition time check for ajax function to excute
    if(winnerTime3 > 0){
      ajaxShow('winner', 3, winnerTime3);
    }
    if(winnerTime2 > 0){
      ajaxShow('winner', 2, winnerTime2);
    }
    if(winnerTime1 > 0){
      ajaxShow('winner', 1, winnerTime1);
    }
    // ajax function timeout reload
    function ajaxShow(prize_name, prize_id, time){
      // set timeout time reload
      var timeNew = time*1000;
      $.ajax({
        type: "post",
        url: "{{ route('ajax.livedraw.gettime') }}",
        data: {
          prize_name : prize_name,
          prize_id : prize_id,
        },
        dataType: "json",
        success: function (response) {
          let classSelector = '';
          let titlePrize = '';
          if(prize_name == 'winner'){
            classSelector = '.winner'+prize_id;
            if(prize_id == 3){
              titlePrize = "3rd Prize";
            }else if(prize_id == 2){
              titlePrize = "2nd Prize";
            }else if(prize_id == 1){
              titlePrize = "1st Prize";
            }
          }else if(prize_name == 'starter'){
            classSelector = '.starter'+prize_id;
          }else if(prize_name == 'consolation'){
            classSelector = '.consolation'+prize_id;
          }
          // do reload
          setTimeout(function(){
            $(classSelector).html(
              '<div class="team-title">'+
                '<div class="team-name">'+response.number+'</div>'+
                '<div class="team-country">'+titlePrize+'</div>'+
              '</div>'
            );
          }, timeNew);// reload timeout
        }
      });
    }

    @endif
  });
</script>
@endsection