<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  {{-- Left Side Of Navbar --}}
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
  {{-- Right Side Of Navbar --}}
  <ul class="navbar-nav ml-auto">
    {{-- Authentication Links --}}
    @guest
      <li><a class="nav-link" href="{{ route('login') }}">{{ trans('titles.login') }}</a></li>
      <li><a class="nav-link" href="{{ route('register') }}">{{ trans('titles.register') }}</a></li>
    @else
      <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            @if ((Auth::User()->profile) && Auth::user()->profile->avatar_status == 1)
                <img src="{{ Auth::user()->profile->avatar }}" alt="{{ Auth::user()->name }}" class="user-avatar-nav">
            @else
                <div class="user-avatar-nav"></div>
            @endif
            {{ Auth::user()->nik }} - {{ Auth::user()->name }} <span class="caret"></span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item {{ Request::is('profile/'.Auth::user()->name, 'profile/'.Auth::user()->name . '/edit') ? 'active' : null }}" href="{{ url('/profile/'.Auth::user()->name) }}">
                {!! trans('titles.profile') !!}
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
      </li>
    @endguest
  </ul>
</nav>
