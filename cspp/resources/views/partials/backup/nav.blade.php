<nav class="navbar navbar-expand-md navbar-light navbar-laravel" style="padding: 0 1rem !important;">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <!-- {!! config('app.name', trans('titles.app')) !!} -->
            <img src="{{ url('/public/logo.jpg') }}" style="width:30%" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            <span class="sr-only">{!! trans('titles.toggleNav') !!}</span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            {{-- Left Side Of Navbar --}}
            <ul class="nav nav-tabs justify-content-center" style="border-bottom:0 !important;">
                @role('admin')
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="javascript:;" id="dropClientList" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Players List
                      </a>
                      <div class="dropdown-menu" aria-labelledby="dropClientList">
                        <a class="dropdown-item {{ Request::is('clients') ? 'active' : null }}" href="{{ url('/clients') }}">All</a>
                        <a class="dropdown-item getdeleteClass" data-value="get-delete-dong-bosku" href="javascript:;">Deleted</a>
                      </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('users', 'users/' . Auth::user()->id, 'users/' . Auth::user()->id . '/edit') ? 'active' : null }}" href="{{ url('/users') }}">
                            {!! trans('titles.adminUserList') !!}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('users/create') ? 'active' : null }}" href="{{ url('/users/create') }}">
                            {!! trans('titles.adminNewUser') !!}
                        </a>
                    </li>

                    <?# luffy 9 Dec 2019 - 07:02 pm | Remove, requested by 6359-Romeo?>
                    <!-- <li class="nav-item">
                        <a class="nav-link {{ Request::is('livechat') ? 'active' : null }}" href="{{ url('/livechat') }}">
                            Livechat Report
                        </a>
                    </li> -->

                @endrole
                @role('leader')
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="javascript:;" id="dropClientList" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Player List
                      </a>
                      <div class="dropdown-menu" aria-labelledby="dropClientList">
                        <a class="dropdown-item {{ Request::is('clients') ? 'active' : null }}" href="{{ url('/clients') }}">All list</a>
                        <a class="dropdown-item getdeleteClass" data-value="get-delete-dong-bosku" href="javascript:;">Deleted list</a>
                      </div>
                    </li>
                @endrole
                @role('cs')
                    <li class="nav-item"></li>
                @endrole
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
                            {{ Auth::user()->name }} <span class="caret"></span>
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
        </div>
    </div>
</nav>
