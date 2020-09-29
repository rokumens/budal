@extends('frontend.layouts.app')

@section('head_css')
@endsection

@section('contents')
<section class="section section-md bg-gray-100">
  <div class="container">
    <div class="row">
      <div class="col-12">

        <div class="blog-post">
          <!-- Badge-->
          <div class="badge badge-secondary">Contact us</div>
          <div class="blog-post-content">
            {!! $seo->content !!}
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection

@section('footer_scripts')
@endsection