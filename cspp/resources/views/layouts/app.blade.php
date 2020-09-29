<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">

<head>
  <meta http-equiv="Cache-Control" content="no-store" />
  <meta http-equiv="cache-control" content="max-age=0" />
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="expires" content="0" />
  <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
  <meta http-equiv="pragma" content="no-cache" />
  @include(backpack_view('inc.head'))
  @include('partials.head')
</head>

<body class="{{ config('backpack.base.body_class') }}">

  @include(backpack_view('inc.main_header'))

  <div class="app-body">

    @include(backpack_view('inc.sidebar'))

    <main class="main pt-2">

       @includeWhen(isset($breadcrumbs), backpack_view('inc.breadcrumbs'))

       @yield('header')

        <div class="container-fluid animated fadeIn">
          
          @if (isset($widgets['before_content']))
            @include(backpack_view('inc.widgets'), [ 'widgets' => $widgets['before_content'] ])
          @endif
          
          @yield('content')
          
          @if (isset($widgets['after_content']))
            @include(backpack_view('inc.widgets'), [ 'widgets' => $widgets['after_content'] ])
          @endif

        </div>

    </main>

  </div><!-- ./app-body -->

  <footer class="{{ config('backpack.base.footer_class') }}">
    @include(backpack_view('inc.footer'))
  </footer>

  @yield('before_scripts')
  @stack('before_scripts')

  @include(backpack_view('inc.scripts'))

  @yield('after_scripts')
  @stack('after_scripts')

  @include('partials.foot')
  
  @yield('footer_scripts')
  @stack('footer_scripts')
</body>
</html>
