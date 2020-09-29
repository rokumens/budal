<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ url('/') }}" class="brand-link">
    {{-- <img src="{{ url('/public/logo.jpg') }}" alt="AdminLTE Logo" class="brand-image" style="opacity: .8"> --}}
    <span class="brand-text font-weight-light">{!! config('app.name') !!}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @if ((Auth::User()->profile) && Auth::user()->profile->avatar_status == 1)
        {{-- <img src="{{ Auth::user()->profile->avatar }}" alt="{{ Auth::user()->name }}" class="user-avatar-nav"> --}}
        <img src="{{ Auth::user()->profile->avatar }}" class="user-avatar-nav img-circle elevation-2" alt="{{ Auth::user()->name }}">
        @else
          <div class="user-avatar-nav"></div>
        @endif
        {{-- {{ Auth::user()->name }} <span class="caret"></span> --}}
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->nik }} - {{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a class="nav-link {{ Request::is('home') ? 'active' : null }}" href="{{ url('/home') }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        @role('admin')
          {{-- Phone Numberst --}}
          <li class="nav-item has-treeview {{ Request::is('numbers*') ? 'menu-open' : null }} {{ Request::is('upload') ? 'menu-open' : null }}">
            <a href="javascript:;" class="nav-link {{ Request::is('numbers*') ? 'active' : null }} {{ Request::is('upload') ? 'active' : null }}" id="dropClientList">
              <i class="nav-icon fas fa-phone"></i>
              <p>
                Phone Numbers
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              {{-- Upload --}}
              <li class="nav-item">
                <a class="nav-link {{ Request::is('upload', 'upload') ? 'active' : '' }}" href="{{ url('/upload') }}">
                  <p>Upload Numbers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/numbers/newnumbers') }}" class="nav-link {{ Request::is('numbers/newnumbers') ? 'active' : null }}">
                  <p>New Numbers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/numbers/assigned') }}" class="nav-link {{ Request::is('numbers/assigned') ? 'active' : null }}">
                  <p>Assigned</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/numbers/contacted') }}" class="nav-link {{ Request::is('numbers/contacted') ? 'active' : null }}">
                  <p>Contacted</p>
                </a>
              </li>
              <li class="nav-item has-treeview {{ Request::is('numbers/followup*') ? 'menu-open' : null }}">
                <a href="javascript:;" class="nav-link {{ Request::is('numbers/followup*') ? 'active' : null }}">
                  <p>
                    Follow Up
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/numbers/followup/interested') }}" class="nav-link {{ Request::is('numbers/followup/interested') ? 'active' : null }}">
                      <p>Interested Players</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/numbers/followup/registered') }}" class="nav-link {{ Request::is('numbers/followup/registered') ? 'active' : null }}">
                      <p>Registered</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item has-treeview {{ Request::is('numbers/leader*') ? 'menu-open' : null }}">
                <a href="javascript:;" class="nav-link {{ Request::is('numbers/leader*') ? 'active' : null }}">
                  <p>
                    Leader
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/numbers/leader/check') }}" class="nav-link {{ Request::is('numbers/leader/check') ? 'active' : null }}">
                      <p>Check</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/numbers/leader/reassign') }}" class="nav-link {{ Request::is('numbers/leader/reassign') ? 'active' : null }}">
                      <p>Re-assign</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="{{ url('/numbers/players') }}" class="nav-link {{ Request::is('numbers/players') ? 'active' : null }}">
                  <p>Lovely Players</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/numbers/trash') }}" class="nav-link {{ Request::is('numbers/trash') ? 'active' : null }}">
                  <p>Trash</p>
                </a>
              </li>
            </ul>
          </li>
          {{-- User List --}}
          <li class="nav-item">
            <a class="nav-link {{ Request::is('/users', 'users') ? 'active' : '' }}" href="{{ url('/users') }}">
              <i class="nav-icon fas fa-users"></i>
              <p>User List</p>
            </a>
          </li>
          {{-- Setting --}}
          <li class="nav-item">
            <a href="{{ url('/settings') }}" class="nav-link {{ Request::is('settings') ? 'active' : null }}" id="dropClientList">
              <i class="nav-icon fas fa-cog"></i>
              <p>Settings</p>
            </a>
            {{-- <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/upload') }}" class="nav-link {{ Request::is('upload') ? 'active' : null }}">
                  <p>Recycle Times</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/upload') }}" class="nav-link {{ Request::is('upload') ? 'active' : null }}">
                  <p>Dynamimic Category Web</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/upload') }}" class="nav-link {{ Request::is('upload') ? 'active' : null }}">
                  <p>Dynamimic Category Game</p>
                </a>
              </li>
            </ul> --}}
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link {{ Request::is('users/create') ? 'active' : null }}" href="{{ url('/users/create') }}">
              <i class="nav-icon fas fa-user-plus"></i>
              <p>
                {!! trans('titles.adminNewUser') !!}
              </p>
            </a>
          </li> --}}
          <?# luffy 9 Dec 2019 - 07:02 pm | Remove, requested by 6359-Romeo?>
          <!-- <li class="nav-item">
              <a class="nav-link {{ Request::is('livechat') ? 'active' : null }}" href="{{ url('/livechat') }}">
                  Livechat Report
              </a>
          </li> -->
        @endrole
        @role('leader')
          {{-- Phone Numbers --}}
          <li class="nav-item has-treeview {{ Request::is('numbers*') ? 'menu-open' : null }}">
            <a href="javascript:;" class="nav-link {{ Request::is('numbers*') ? 'active' : null }}" id="dropClientList">
              <i class="nav-icon fas fa-phone"></i>
              <p>
                Phone Numbers
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/numbers/newnumbers') }}" class="nav-link {{ Request::is('numbers/newnumbers') ? 'active' : null }}">
                  <p>New Numbers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/numbers/assigned') }}" class="nav-link {{ Request::is('numbers/assigned') ? 'active' : null }}">
                  <p>Assigned</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/numbers/contacted') }}" class="nav-link {{ Request::is('numbers/contacted') ? 'active' : null }}">
                  <p>Contacted</p>
                </a>
              </li>
              <li class="nav-item has-treeview {{ Request::is('numbers/followup*') ? 'menu-open' : null }}">
                <a href="javascript:;" class="nav-link {{ Request::is('numbers/followup*') ? 'active' : null }}">
                  <p>
                    Follow Up
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/numbers/followup/interested') }}" class="nav-link {{ Request::is('numbers/followup/interested') ? 'active' : null }}">
                      <p>Interested Players</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/numbers/followup/registered') }}" class="nav-link {{ Request::is('numbers/followup/registered') ? 'active' : null }}">
                      <p>Registered</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item has-treeview {{ Request::is('numbers/leader*') ? 'menu-open' : null }}">
                <a href="javascript:;" class="nav-link {{ Request::is('numbers/leader*') ? 'active' : null }}">
                  <p>
                    Leader
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/numbers/leader/check') }}" class="nav-link {{ Request::is('numbers/leader/check') ? 'active' : null }}">
                      <p>Check</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/numbers/leader/reassign') }}" class="nav-link {{ Request::is('numbers/leader/reassign') ? 'active' : null }}">
                      <p>Re-assign</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="{{ url('/numbers/players') }}" class="nav-link {{ Request::is('numbers/players') ? 'active' : null }}">
                  <p>Lovely Players</p>
                </a>
              </li>
            </ul>
          </li>
        @endrole
        @role('cs')
          {{-- Phone Numbers --}}
          <li class="nav-item has-treeview {{ Request::is('numbers*') ? 'menu-open' : null }}">
            <a href="javascript:;" class="nav-link {{ Request::is('numbers*') ? 'active' : null }}" id="dropClientList">
              <i class="nav-icon fas fa-phone"></i>
              <p>
                Phone Numbers
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">  
              <li class="nav-item">
                <a href="{{ url('/numbers/assigned') }}" class="nav-link {{ Request::is('numbers/assigned') ? 'active' : null }}">
                  <p>Assigned</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/numbers/contacted') }}" class="nav-link {{ Request::is('numbers/contacted') ? 'active' : null }}">
                  <p>Contacted</p>
                </a>
              </li>
              <li class="nav-item has-treeview {{ Request::is('numbers/followup*') ? 'menu-open' : null }}">
                <a href="javascript:;" class="nav-link {{ Request::is('numbers/followup*') ? 'active' : null }}">
                  <p>
                    Follow Up
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/numbers/followup/interested') }}" class="nav-link {{ Request::is('numbers/followup/interested') ? 'active' : null }}">
                      <p>Interested Players</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/numbers/followup/registered') }}" class="nav-link {{ Request::is('numbers/followup/registered') ? 'active' : null }}">
                      <p>Registered</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        @endrole
        @if (config('app.env') != 'production')
        {{-- Phone Numbers --}}
        <li class="nav-item has-treeview {{ Request::is('devtools*') ? 'menu-open' : null }}">
          <a href="javascript:;" class="nav-link {{ Request::is('devtools*') ? 'active' : null }}" id="dropClientList">
            <i class="nav-icon fas fa-code"></i>
            <p>
              Dev Tools
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">  
            <li class="nav-item">
              <a href="{{ url('/devtools/database') }}" class="nav-link {{ Request::is('devtools/database') ? 'active' : null }}">
                <p>Database</p>
              </a>
            </li>
          </ul>
        </li>
        @endif
        {{-- Report --}}
        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>{{ __('Logout') }}</p>
          </a>
          <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>

        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>