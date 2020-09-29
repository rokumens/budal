@extends('frontend.layouts.app')

@section('head_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha256-rByPlHULObEjJ6XQxW/flG2r+22R5dKiAoef+aXWfik=" crossorigin="anonymous" />
@endsection

@section('contents')
<section class="section section-md bg-dark flag">
  <div class="container">
    <div class="row row-50">
      <div class="col-lg-12">
        <div class="main-component">
          <!-- Heading Component-->
          <article class="heading-component bg-white">
            <div class="heading-component-inner pt-2 ml-1 mr-1">
              <h5 class="heading-component-title">Result</h5>
              <a class="button-gray-outline"><input type="text" class="form-control datepicker" name="date_for_number" id="date_for_number" placeholder="Draw Date" aria-label="Draw Date" aria-describedby="basic-addon2" autocomplete="off" data-date-end-date="+1d" readonly></a>
            </div>
          </article>
          <!-- Game Result Bug-->
          <article class="game-result">
            <div class="row mx-auto text-center pb-3 appendAjax">
              @foreach($dataNumber as $value)
              <div class="col-md-4">
                <div class="result-wrap">
                  <div class="result-body">
                    <div class="draw-no">
                    Draw No: <span>{{ $value['winner'][0]->draw_id }}</span>
                    </div>
                    <div class="draw-date">{{ date('l, d F Y', strtotime($value['date_for_number'])) }}</div>
                    <div class="item-wrap">
                      <div class="prize-item">
                        <table class="tbl-price">
                          <tbody>
                            <tr>
                              <td class="price-title">
                                1st
                              </td>
                              <td class="single-num">
                                {{ $value['winner'][0]->number }}
                              </td>
                            </tr>
                            <tr>
                              <td class="price-title">2<sup>nd</sup></td>
                              <td class="single-num">{{ $value['winner'][1]->number }}</td>
                            </tr>
                            <tr>
                              <td class="price-title">3<sup>rd</sup></td>
                              <td class="single-num">{{ $value['winner'][2]->number }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="multi">
                        <div class="prize">
                          <div class="header">Starter Prizes</div>
                          <table class="wrap-result">
                            <tbody>
                              <tr>
                                <td class="multi-num">{{ $value['starter'][0]->number }}</td>
                                <td class="multi-num">{{ $value['starter'][1]->number }}</td>
                                <td class="multi-num">{{ $value['starter'][2]->number }}</td>
                              </tr>
                              <tr>
                                <td class="multi-num">{{ $value['starter'][3]->number }}</td>
                                <td class="multi-num">{{ $value['starter'][4]->number }}</td>
                                <td class="multi-num">{{ $value['starter'][5]->number }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="prize">
                          <div class="header">Consolation Prizes</div>
                          <table class="wrap-result">
                            <tbody>
                              <tr>
                                <td class="multi-num">{{ $value['consolation'][0]->number }}</td>
                                <td class="multi-num">{{ $value['consolation'][1]->number }}</td>
                                <td class="multi-num">{{ $value['consolation'][2]->number }}</td>
                              </tr>
                              <tr>
                                <td class="multi-num">{{ $value['consolation'][3]->number }}</td>
                                <td class="multi-num">{{ $value['consolation'][4]->number }}</td>
                                <td class="multi-num">{{ $value['consolation'][5]->number }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </article>
          <div class="game-info game-info-creative">
            @if(count($allDraw) > 0)
            {{ $allDraw->links() }}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  @if($seo->content != '')
  <div class="container">
    <article class="bg-white custom-content-lineHeight">
      <div class="p-3">
        {!! $seo->content !!}
      </div>
    </article>
  </div>
  @endif
</section>
@endsection

@section('footer_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha256-KM512VNnjElC30ehFwehXjx1YCHPiQkOPmqnrWtpccM=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function () {
    $( ".datepicker" ).datepicker({
      dateFormat : 'yy-mm-dd'
    });
    $(".datepicker").on("change",function(){
      var selected = $(this).val();
      // ajax
      $.ajax({
        type: "POST",
        url: "{{ url('ajax/livedraw/getnumberbydate') }}",
        data: {
          date : selected,
        },
        dataType: "json",
        success: function (response) {
          // if response not false
          if(response != false){
            // put necessary response into variable
            let date = response.date;
            let draw = response.draw_id;
            let winner1 = response.winner[0].number;
            let winner2 = response.winner[1].number;
            let winner3 = response.winner[2].number;
            let starter1 = response.starter[0].number;
            let starter2 = response.starter[1].number;
            let starter3 = response.starter[2].number;
            let starter4 = response.starter[3].number;
            let starter5 = response.starter[4].number;
            let starter6 = response.starter[5].number;
            let consolation1 = response.consolation[0].number;
            let consolation2 = response.consolation[1].number;
            let consolation3 = response.consolation[2].number;
            let consolation4 = response.consolation[3].number;
            let consolation5 = response.consolation[4].number;
            let consolation6 = response.consolation[5].number;
            // put search result into html
            $('.appendAjax').html(
              '<div class="col-md-4">'+
                '<div class="result-wrap">'+
                  '<div class="result-body">'+
                    '<div class="draw-no">'+
                    'Draw No: <span>'+draw+'</span>'+
                    '</div>'+
                    '<div class="draw-date">'+date+'</div>'+
                    '<div class="item-wrap">'+
                      '<div class="prize-item">'+
                        '<table class="tbl-price">'+
                          '<tbody>'+
                            '<tr>'+
                              '<td class="price-title">1st</td>'+
                              '<td class="single-num">'+winner1+'</td>'+
                            '</tr>'+
                            '<tr>'+
                              '<td class="price-title">2<sup>nd</sup></td>'+
                              '<td class="single-num">'+winner2+'</td>'+
                            '</tr>'+
                            '<tr>'+
                              '<td class="price-title">3<sup>rd</sup></td>'+
                              '<td class="single-num">'+winner3+'</td>'+
                            '</tr>'+
                          '</tbody>'+
                        '</table>'+
                      '</div>'+
                      '<div class="multi">'+
                        '<div class="prize">'+
                          '<div class="header">Starter Prizes</div>'+
                          '<table class="wrap-result">'+
                            '<tbody>'+
                              '<tr>'+
                                '<td class="multi-num">'+starter1+'</td>'+
                                '<td class="multi-num">'+starter2+'</td>'+
                                '<td class="multi-num">'+starter3+'</td>'+
                              '</tr>'+
                              '<tr>'+
                                '<td class="multi-num">'+starter4+'</td>'+
                                '<td class="multi-num">'+starter5+'</td>'+
                                '<td class="multi-num">'+starter6+'</td>'+
                              '</tr>'+
                            '</tbody>'+
                          '</table>'+
                        '</div>'+
                        '<div class="prize">'+
                          '<div class="header">Consolation Prizes</div>'+
                          '<table class="wrap-result">'+
                            '<tbody>'+
                              '<tr>'+
                                '<td class="multi-num">'+consolation1+'</td>'+
                                '<td class="multi-num">'+consolation2+'</td>'+
                                '<td class="multi-num">'+consolation3+'</td>'+
                              '</tr>'+
                              '<tr>'+
                                '<td class="multi-num">'+consolation4+'</td>'+
                                '<td class="multi-num">'+consolation5+'</td>'+
                                '<td class="multi-num">'+consolation6+'</td>'+
                              '</tr>'+
                            '</tbody>'+
                          '</table>'+
                        '</div>'+
                      '</div>'+
                    '</div>'+
                  '</div>'+
                '</div>'+
              '</div>'
            );
          }else{
            // if response false show not found
            $('.appendAjax').html(
              '<p class="game-result-title mx-auto pt-3">No result found.</p>'
            );
          }
        }
      });
    });
  });
</script>
@endsection