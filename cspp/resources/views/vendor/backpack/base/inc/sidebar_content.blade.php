<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="nav-icon fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

{{-- <li class="nav-title">Main</li> --}}

<li class="nav-item nav-dropdown">
  <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-phone"></i> Phone Numbers</a>
  <ul class="nav-dropdown-items">
    @can('menu-upload')
    <li class="nav-item"><a class="nav-link" href="{{ url('numbers/upload') }}"><i class="nav-icon fa fa-upload"></i> <span>Upload</span></a></li>
    @endcan
    @can('menu-newnumbers')
    <li class="nav-item"><a class="nav-link" href="{{ url('numbers/newnumbers') }}"><i class="nav-icon fa fa-list"></i> <span>New Numbers</span></a></li>
    @endcan
    @can('menu-assigned')
    <li class="nav-item"><a class="nav-link" href="{{ url('numbers/assigned') }}"><i class="nav-icon fa fa-tag"></i> <span>Assigned</span></a></li>
    @endcan
    @can('menu-contacted')
    <li class="nav-item"><a class="nav-link" href="{{ url('numbers/contacted') }}"><i class="nav-icon fa fa-tag"></i> <span>Contacted</span></a></li>
    @endcan

    @if(backpack_user()->can('menu-interested') || backpack_user()->can('menu-registered'))
    <li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-newspaper-o"></i> Follow Up</a>
      <ul class="nav-dropdown-items">
        @can('menu-interested')
        <li class="nav-item"><a class="nav-link" href="{{ url('numbers/followup/interested') }}"><i class="nav-icon fa fa-smile-o"></i> <span>Interested</span></a></li>
        @endcan
        @can('menu-registered')
        <li class="nav-item"><a class="nav-link" href="{{ url('numbers/followup/registered') }}"><i class="nav-icon fa fa-registered"></i> <span>Registered</span></a></li>
        @endcan
      </ul>
    </li>
    @endif

    @if(backpack_user()->can('menu-check') || backpack_user()->can('menu-reassign'))
    <li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-newspaper-o"></i> Leader</a>
      <ul class="nav-dropdown-items">
        @can('menu-check')
        <li class="nav-item"><a class="nav-link" href="{{ url('numbers/leader/check') }}"><i class="nav-icon fa fa-list"></i> <span>Check</span></a></li>
        @endcan
        @can('menu-reassign')
        <li class="nav-item"><a class="nav-link" href="{{ url('numbers/leader/reassign') }}"><i class="nav-icon fa fa-list-alt"></i> <span>Re-assign</span></a></li>
        @endcan
      </ul>
    </li>
    @endcan
    
    @can('menu-players')
    <li class="nav-item"><a class="nav-link" href="{{ url('numbers/players') }}"><i class="nav-icon fa fa-money"></i> <span>Lovely Players</span></a></li>
    @endcan
    @can('menu-trash')
    <li class="nav-item"><a class="nav-link" href="{{ url('numbers/trash') }}"><i class="nav-icon fa fa-trash"></i> <span>Trash</span></a></li>
    @endcan
  </ul>
</li>

<!-- Settings -->
@can('menu-settings')
<li class="nav-item"><a class="nav-link" href="{{ url('settings') }}"><i class="nav-icon fa fa-gear"></i> <span>Settings</span></a></li>
@endcan

{{-- <li class="nav-title">First-Party Packages</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-newspaper-o"></i> News</a>
    <ul class="nav-dropdown-items">
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('article') }}"><i class="nav-icon fa fa-newspaper-o"></i> <span>Articles</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('category') }}"><i class="nav-icon fa fa-list"></i> <span>Categories</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('tag') }}"><i class="nav-icon fa fa-tag"></i> <span>Tags</span></a></li>
    </ul>
</li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('page') }}"><i class="nav-icon fa fa-file-o"></i> <span>Pages</span></a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('menu-item') }}"><i class="nav-icon fa fa-list"></i> <span>Menu</span></a></li> --}}

<!-- Users, Roles Permissions -->
@if(backpack_user()->can('manage-users') || backpack_user()->can('manage-roles') || backpack_user()->can('manage-permissions'))
  <li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-group"></i> Authentication</a>
    <ul class="nav-dropdown-items">
      @can('manage-users')
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon fa fa-user"></i> <span>Users</span></a></li>
      @endcan
      @can('manage-roles')
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon fa fa-group"></i> <span>Roles</span></a></li>
      @endcan
      @can('manage-permissions')
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon fa fa-key"></i> <span>Permissions</span></a></li>
      @endcan
    </ul>
  </li>
@endif

<!-- Devtools -->
@if (!App::environment('production'))
  <li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-code"></i> Dev tools</a>
    <ul class="nav-dropdown-items">
      <li class="nav-item"><a class="nav-link" href="{{ url('/devtools/database') }}"><i class="nav-icon fa fa-database"></i> <span>Database</span></a></li>
    </ul>
  </li>
@endif


<!-- logout -->
<li class="nav-item"><a class="nav-link" href="{{ url('/logout') }}"><i class="nav-icon fa fa-sign-out"></i> <span>Log out</span></a></li>

{{-- <li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-cogs"></i> Advanced</a>
    <ul class="nav-dropdown-items">
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon fa fa-files-o"></i> <span>File manager</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('backup') }}"><i class="nav-icon fa fa-hdd-o"></i> <span>Backups</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('log') }}"><i class="nav-icon fa fa-terminal"></i> <span>Logs</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('setting') }}"><i class="nav-icon fa fa-cog"></i> <span>Settings</span></a></li>
    </ul>
</li> --}}

{{-- <li class="nav-title">Demo Entities</li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('monster') }}"><i class="nav-icon fa fa-optin-monster"></i> <span>Monsters</span></a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('icon') }}"><i class="nav-icon fa fa-info-circle"></i> <span>Icons</span></a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('product') }}"><i class="nav-icon fa fa-shopping-cart"></i> <span>Products</span></a></li> --}}