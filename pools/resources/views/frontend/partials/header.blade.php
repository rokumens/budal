<header class="section page-header rd-navbar-dark">
  <!-- RD Navbar-->
  <div class="rd-navbar-wrap">
    <nav class="rd-navbar rd-navbar-corporate" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed"
      data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-fixed"
      data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static"
      data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static"
      data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="166px" data-xl-stick-up-offset="166px"
      data-xxl-stick-up-offset="166px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
      <div class="rd-navbar-panel rd-navbar-darker">
        <!-- RD Navbar Toggle-->
        <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-main"><span></span></button>
        <!-- RD Navbar Panel-->
        <div class="rd-navbar-panel-inner container">
          <div class="rd-navbar-collapse rd-navbar-panel-item rd-navbar-panel-item-left">

            <!-- Owl Carousel-->
            <div class="owl-carousel-navbar owl-carousel-inline-outer">
              <div class="owl-inline-nav">
                <button class="owl-arrow owl-arrow-prev"></button>
                <button class="owl-arrow owl-arrow-next"></button>
              </div>
              <div class="owl-carousel-inline-wrap">
                <div class="owl-carousel owl-carousel-inline" data-items="1" data-dots="false" data-nav="true" data-autoplay="true" data-autoplay-speed="3200" data-stage-padding="0" data-loop="true" data-margin="10" data-mouse-drag="false" data-touch-drag="false" data-nav-custom=".owl-carousel-navbar">
                  @foreach($lastWinner10 as $value)
                  <!-- Post Inline-->
                  <article class="post-inline">
                  <time class="post-inline-time" datetime="{{ date('Y', strtotime($value->date_for_number)) }}">{{ date('F d, Y', strtotime($value->date_for_number)) }}</time>
                  <p class="post-inline-title">{{ $value->number }}</p>
                  </article>
                  @endforeach
                </div>
              </div>
            </div>

          </div>
          <div class="rd-navbar-panel-item rd-navbar-panel-item-right">
          <ul class="list-inline list-inline-bordered">
            <li><a class="link link-icon link-icon-left link-classic" href="{{ url('/livedraw') }}"><span class="icon fl-bigmug-line-login12"></span><span class="link-icon-text">Live Draw</span></a></li>
          </ul>
          </div>
          <div class="rd-navbar-collapse-toggle rd-navbar-fixed-element-1" data-rd-navbar-toggle=".rd-navbar-collapse"><span></span></div>
        </div>
      </div>
      <div class="rd-navbar-main">
        <div class="rd-navbar-main-top">
          <div class="rd-navbar-main-container container">
          <!-- RD Navbar Brand-->
          <div class="rd-navbar-brand">
            <a class="brand" href="/">
            @if(!is_null($logo))
            <img class="brand-logo-light" src="{{ asset('public/upload/'.$logo['logo']) }}"
              alt="logo" width="99" height="66">
            @else
            <img class="brand-logo-dark" src="{{ asset('frontend/images/logo-default-99x66.png') }}"
              alt="logo" width="99" height="66" />
            <img class="brand-logo-light"
              src="{{ asset('frontend/images/logo-inverse-99x66.png') }}" alt="logo" width="99"
              height="66" />
            @endif
            </a>
          </div>
          <div class="rd-navbar-main-element">
            <!-- RD Navbar List-->
            <div class="rd-navbar-list-outer">
            <!-- Heading Component-->
            <div class="card-group-custom card-standing-index text-center" id="accordion1" role="tablist" aria-multiselectable="false">
              @if($lastWinner)
              <span class="home-page-header-date-time">{{ date('l, d F Y', strtotime($lastWinner->date_for_number)) }}</span> | 1st Prize <br>
              <div class="baris-bola home-page-header-first-prize">
              @php
              $word = str_split($lastWinner->number);
              @endphp
              @foreach($word as $key => $value)
              <span class="bola">{{ $value }}</span>
              @endforeach
              </div>
              @endif
              <div style="clear:both;"></div>
            </div>
            </div>
            <!-- RD Navbar Search-->
            <div class="rd-navbar-search">
              <button class="rd-navbar-search-toggle" data-rd-navbar-toggle=".rd-navbar-search"><span></span></button>
              <!-- countdown -->
              <div class="countdown-circle-container" data-countdown="data-countdown" data-to="{{ $configCountdown['countdown_stop'] }}" style="width: 300px">
                <div class="countdown-block countdown-block-hours">
                  <svg class="countdown-circle" x="0" y="0" width="170" height="170" viewBox="0 0 170 170" data-progress-hours="">
                    <circle class="countdown-circle-bg" cx="85" cy="85" r="83"></circle>
                    <circle class="countdown-circle-fg clipped" cx="85" cy="85" r="83" clip-path="url(#mmwqrybn)"></circle>
                  <clipPath id="mmwqrybn"><path d="M 85 85 L 85 -37.39999999999999 A 122.39999999999999 122.39999999999999 0 0 1 85 207.39999999999998 A 122.39999999999999 122.39999999999999 0 0 1 12.36231145616975 183.51662906844462"></path></clipPath></svg>
                  <div class="countdown-wrap">
                    <div class="countdown-counter head" data-counter-hours="">14</div>
                    <div class="countdown-title head">hours</div>
                  </div>
                </div>
                <div class="countdown-block countdown-block-minutes">
                  <svg class="countdown-circle" x="0" y="0" width="170" height="170" viewBox="0 0 170 170" data-progress-minutes="">
                    <circle class="countdown-circle-bg" cx="85" cy="85" r="83"></circle>
                    <circle class="countdown-circle-fg clipped" cx="85" cy="85" r="83" clip-path="url(#hpwqqsfw)"></circle>
                  <clipPath id="hpwqqsfw"><path d="M 85 85 L 85 -37.39999999999999 A 122.39999999999999 122.39999999999999 0 0 1 139.33741335793968 194.6777347941158"></path></clipPath></svg>
                  <div class="countdown-wrap">
                    <div class="countdown-counter head" data-counter-minutes="">25</div>
                    <div class="countdown-title head">minutes</div>
                  </div>
                </div>
                <div class="countdown-block countdown-block-seconds">
                  <svg class="countdown-circle" x="0" y="0" width="170" height="170" viewBox="0 0 170 170" data-progress-seconds="">
                    <circle class="countdown-circle-bg" cx="85" cy="85" r="83"></circle>
                    <circle class="countdown-circle-fg clipped" cx="85" cy="85" r="83" clip-path="url(#mccewkux)"></circle>
                  <clipPath id="mccewkux"><path d="M 85 85 L 85 -37.39999999999999 A 122.39999999999999 122.39999999999999 0 0 1 85 207.39999999999998 A 122.39999999999999 122.39999999999999 0 0 1 8.480302605404546 180.53269550598654"></path></clipPath></svg>
                  <div class="countdown-wrap">
                    <div class="countdown-counter head" data-counter-seconds="">36</div>
                    <div class="countdown-title head">seconds</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>
        <div class="rd-navbar-main-bottom">
          <div class="rd-navbar-main-container container">
          <!-- RD Navbar Nav-->
          <ul class="rd-navbar-nav">
            <li class="rd-nav-item {{ Request::is('/') ? 'active' : '' }}"><a class="rd-nav-link" href="{{ url('/') }}">Home</a></li>
            <li class="rd-nav-item {{ Request::is('result') ? 'active' : '' }}"><a class="rd-nav-link" href="{{ url('/result') }}">Result</a></li>
            <li class="rd-nav-item {{ Request::is('livedraw') ? 'active' : '' }}"><a class="rd-nav-link" href="{{ url('/livedraw') }}">Live Draw</a></li>
            <li class="rd-nav-item {{ Request::is('about') ? 'active' : '' }}"><a class="rd-nav-link" href="{{ url('/about') }}">About Us</a></li>
            <li class="rd-nav-item {{ Request::is('contact') ? 'active' : '' }}"><a class="rd-nav-link" href="{{ url('/contact') }}">Contact us</a></li>
          </ul>
          <div class="rd-navbar-main-element">
            <ul class="list-inline list-inline-1">
            @foreach($socials as $value)
            <li title="{{ $value->title }}"><a class="icon icon-xs icon-light {{ $value->icon }}" target="_blank" href="{{ $value->url }}"></a></li>
            @endforeach
            </ul>
          </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>