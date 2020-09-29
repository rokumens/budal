@extends('frontend.layouts.app')

@section('head_css')
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
              <a class="button button-xs button-gray-outline" href="{{ url('result') }}">All result</a>
            </div>
          </article>
          <!-- Game Result Bug-->
          <article class="game-result">
            <div class="row mx-auto text-center">
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
            <div class="game-info game-info-creative pb-0">
            </div>
          </article>
        </div>
      </div>
    </div>
  </div>
  @if($seo->content != '')
  <div class="container">
    <article class="bg-white custom-content-lineHeight">
      <div class="p-4">
        {!! $seo->content !!}
      </div>
    </article>
  </div>
  @endif
</section>

{{-- Pop up --}}
@if($popup['status'] == 1)
  <div id="popup" class="modal fade" style="z-index: 99999;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{!! $popup['title'] !!}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          {!! $popup['content'] !!}
        </div>
      </div>
    </div>
  </div>
@endif

@endsection
  
@section('footer_scripts')
  @if($popup['status'] == 1)
    <script>
      @if($popup['timeout'] > 0)
        $(document).ready(function () {
          let timeout = {{ $popup['timeout'] }}*1000;
          setTimeout(() => {
            $("#popup").modal('show');
          }, timeout);
        });
      @else
        $(document).ready(function () {
          $("#popup").modal('show');
        });
      @endif
    </script>
  @endif
@endsection