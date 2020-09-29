<footer class="section footer-classic footer-classic-dark context-dark">
  <div class="footer-classic-main">
    <div class="container">
      <!-- RD Mailform-->
      <div class="row row-50">
        <div class="col-lg-5 text-center text-sm-left">
          <article class="unit unit-sm-horizontal unit-middle justify-content-center justify-content-sm-start footer-classic-info">
            <div class="unit-left">
              <a class="brand brand-md" href="/">
                @if(!is_null($logo))
                  <img class="brand-logo " src="{{ asset('public/upload/'.$logo['logo']) }}" alt="logo">
                @else
                  <img class="brand-logo " src="{{ asset('frontend/images/logo-soccer-default-95x126.png') }}" alt="logo" width="95" height="126"/>
                @endif
              </a>
            </div>
            <div class="unit-body">
              <p>{{ $footer_description }}</p>
            </div>
          </article>
          <div class="group-md group-middle">
            <div class="group-item">
              <ul class="list-inline list-inline-xs">
                @foreach($socials as $value)
                <li title="{{ $value->title }}"><a class="icon icon-corporate {{ $value->icon }}" target="_blank" href="{{ $value->url }}"></a></li>
                @endforeach
              </ul>
            </div>
            <a class="button button-sm button-gray-outline" href="{{ url('/contact') }}">Get in Touch</a>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="row">
            <div class="col-lg-6">
              <div class="wrap-posts-classic">
                <!-- Post Classic-->
                <article class="post-classic">
                  <div class="post-classic-main">
                    <p class="post-classic-title">{{ count($footers) > 0 ? strip_tags($footers[0]->content) : NULL }}</p>
                  </div>
                </article>
                <!-- Post Classic-->
                <article class="post-classic">
                  <div class="post-classic-main">
                    <p class="post-classic-title">{{ count($footers) > 0 ? strip_tags($footers[1]->content) : NULL }}</p>
                  </div>
                </article>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="wrap-posts-classic">
                <!-- Post Classic-->
                <article class="post-classic">
                  <div class="post-classic-main">
                    <p class="post-classic-title">{{ count($footers) > 0 ? strip_tags($footers[2]->content) : NULL }}</p>
                  </div>
                </article>
                <!-- Post Classic-->
                <article class="post-classic">
                  <div class="post-classic-main">
                    <p class="post-classic-title">{{ count($footers) > 0 ? strip_tags($footers[3]->content) : NULL }}</p>
                  </div>
                </article>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-classic-aside footer-classic-darken">
    <div class="container">
      <div class="layout-justify">
        <!-- Rights-->
        <p class="rights"><span>{{ config('app.name') }}</span><span>&nbsp;&copy;&nbsp;</span><span class="copyright-year"></span><span>.&nbsp;</span></p>
        <nav class="nav-minimal">
          <ul class="nav-minimal-list">
            <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
            <li class="{{ Request::is('result') ? 'active' : '' }}"><a href="{{ url('/result') }}">Result</a></li>
            <li class="{{ Request::is('livedraw') ? 'active' : '' }}"><a href="{{ url('/livedraw') }}">Live Draw</a></li>
            <li class="{{ Request::is('about') ? 'active' : '' }}"><a href="{{ url('/about') }}">About Us</a></li>
            <li class="{{ Request::is('contact') ? 'active' : '' }}"><a href="{{ url('/contact') }}">Contact us</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</footer>
