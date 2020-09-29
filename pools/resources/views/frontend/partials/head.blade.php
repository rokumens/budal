<link rel='icon' type='image/png' href="{{ asset('frontend/images/favicon.png') }}">
<link rel='apple-touch-icon' type='image/png' href="{{ asset('frontend/images/favicon.png') }}"> 

{{-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --}}
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Stylesheets-->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Kanit:300,400,500,500i,600,900%7CRoboto:400,900">
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/fonts.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" id="main-styles-link">
<link rel="stylesheet" href="{{ asset('frontend/css/master.css') }}" id="main-styles-link">
<link rel="stylesheet" href="{{ asset('frontend/media/css/uibase.css?v=1586403479') }}" />
<style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
<style>
  section.flag {
    background: url('{{ asset("public/upload/$background") }}');no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;
  }
  .custom-content-lineHeight{
    line-height: 26px;
  }
  .custom-footer-lineHeight{
    line-height: 20px;
  }
  .post-classic{
    font-weight: 400 !important; 
    text-transform: none !important;
  }
  .countdown-counter.head {
    font-size: 20px;
  }
  .countdown-title.head {
    font-size: 9px;
  }
</style>

@yield('head_css')