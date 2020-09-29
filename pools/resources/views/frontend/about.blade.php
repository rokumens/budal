@extends('frontend.layouts.app')

@section('head_css')
@endsection

@section('contents')
<section class="section section-md bg-gray-100">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="comment-modern">
          <svg version="1.1" x="0px" y="0px" width="6.888px" height="4.68px" viewBox="0 0 6.888 4.68" enable-background="new 0 0 6.888 4.68" xml:space="preserve">
            <path fill="#171617" d="M1.584,0h1.8L2.112,4.68H0L1.584,0z M5.112,0h1.776L5.64,4.68H3.528L5.112,0z"></path>
          </svg>
          <p class="comment-modern-title">
            {!! $seo->content !!}
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('footer_scripts')
@endsection