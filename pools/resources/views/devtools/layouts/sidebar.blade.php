<nav id="sidebar" class="sidebar-wrapper">
  <div class="sidebar-content">
    <div class="sidebar-brand">
      <a href="#">Devtools</a>
      <div id="close-sidebar">
        <i class="fas fa-times"></i>
      </div>
    </div>
    <div class="sidebar-header">
      <div class="user-pic">
        <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
          alt="User picture">
      </div>
      <div class="user-info">
        <span class="user-name">APG
          <strong>Developer</strong>
        </span>
        <span class="user-role">Dev</span>
        <span class="user-status">
          <i class="fa fa-circle"></i>
          <span>Online</span>
        </span>
      </div>
    </div>
    <!-- sidebar-search  -->
    <div class="sidebar-menu">
      <ul>
        <li class="header-menu">
          <span>Devtools</span>
        </li>
        <li>
          <a href="{{ url('/devtools/index') }}">
            <i class="fa fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="{{ url('/devtools/generator') }}">
            <i class="fa fa-file"></i>
            <span>Fake Generator</span>
          </a>
        </li>
        <li class="header-menu">
          <span>Extra</span>
        </li>
        <li>
          <a href="{{ url('/') }}" target="__blank">
            <i class="fa fa-home"></i>
            <span>Homepage</span>
          </a>
        </li>
        {{-- <li>
          <a href="#">
            <i class="fa fa-calendar"></i>
            <span>Calendar</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-folder"></i>
            <span>Examples</span>
          </a>
        </li> --}}
      </ul>
    </div>
    <!-- sidebar-menu  -->
  </div>
  <!-- sidebar-content  -->
  {{-- <div class="sidebar-footer">
    <a href="#">
      <i class="fa fa-bell"></i>
      <span class="badge badge-pill badge-warning notification">3</span>
    </a>
    <a href="#">
      <i class="fa fa-envelope"></i>
      <span class="badge badge-pill badge-success notification">7</span>
    </a>
    <a href="#">
      <i class="fa fa-cog"></i>
      <span class="badge-sonar"></span>
    </a>
    <a href="#">
      <i class="fa fa-power-off"></i>
    </a>
  </div> --}}
</nav>