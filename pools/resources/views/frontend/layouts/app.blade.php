<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="@hasSection('template_title')@yield('template_title') | @endif {{ config('app.name', Lang::get('titles.app')) }}.com"> 
    {!! SEO::generate(true) !!}
    @include('frontend.partials.head')

    @if(!is_null($arrScriptsHead))
      @foreach($arrScriptsHead as $singScript)
      {!! $singScript->script !!}
      @endforeach
    @endif
    
  </head>
  <body>
    <div class="ie-panel">
      <a href="https://windows.microsoft.com/en-US/internet-explorer/"><img src="{{ asset('frontend/images/ie8-panel/warning_bar_0000_us.jpg') }}" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a>
    </div>
    <div class="preloader">
      <div class="preloader-body">
        <div class="preloader-item"></div>
      </div>
    </div>
    <!-- Page-->
    <div class="page">
      <!-- Page Header-->
      @include('frontend.partials.header')
      <!-- Swiper-->
      {{-- @include('frontend.partials.swiper') --}}

      <!-- Latest News-->
      @yield('contents')
      <!-- Page Footer-->
      @include('frontend.partials.footer')

      {{--
      <!-- Modal Video-->
      <div class="modal modal-video fade" id="modal1" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" width="560" height="315" data-src="https://www.youtube.com/embed/uSzNA2_y46c"></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    --}}
    
    <!-- Foot -->
    @include('frontend.partials.foot')
  </body>
</html>
