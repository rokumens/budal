@extends('layouts.app')

@section('template_title')
  SEO settings edit
@endsection

@section('template_linked_css')
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
@endsection

@section('content')
<div class="container">
  <div class="row">

    <div class="col-sm-12 mb-3">
      <div class="card">
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
              Edit SEO
            </span>
            <div class="pull-right">
                <a href="{{ route('settings-seo') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to SEO">
                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                    Back to SEO
                </a>
            </div>
          </div>
        </div>
        <div class="card-body">
          {!! Form::open(array('route' => 'apgadm/settings/seo/update', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{ $data->id }}">
            <input type="hidden" name="type" value="seo">
            <div class="form-group has-feedback row {{ $errors->has('menu_name') ? ' has-error ' : '' }}">
              {!! Form::label('menu_name', 'Menu Name', array('class' => 'col-md-3 control-label')); !!}
              <div class="col-md-9">
                <div class="input-group">
                  {!! Form::text('menu_name', $data->menu_name, array('id' => 'menu_name', 'class' => 'form-control', 'placeholder' => 'Menu Name')) !!}
                  <div class="input-group-append">
                    <label for="menu_name" class="input-group-text">
                      SEO
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group has-feedback row {{ $errors->has('title') ? ' has-error ' : '' }}">
              {!! Form::label('title', 'Title', array('class' => 'col-md-3 control-label')); !!}
              <div class="col-md-9">
                <div class="input-group">
                  {!! Form::text('title', $data->title, array('id' => 'title', 'class' => 'form-control', 'placeholder' => 'Title')) !!}
                  <div class="input-group-append">
                    <label for="title" class="input-group-text">
                      SEO
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group has-feedback row {{ $errors->has('keyword') ? ' has-error ' : '' }}">
              {!! Form::label('keyword', 'Keyword', array('class' => 'col-md-3 control-label')); !!}
              <div class="col-md-9">
                <div class="input-group">
                  {!! Form::text('keyword', $data->keyword, array('id' => 'keyword', 'class' => 'form-control', 'placeholder' => 'Keyword')) !!}
                  <div class="input-group-append">
                    <label for="keyword" class="input-group-text">
                      SEO
                    </label>
                  </div>
                </div>
                <small class="form-text text-muted">Use separator ',' to add more value example : value1,value2,value3</small>
              </div>
            </div>
            <div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}">
              {!! Form::label('description', 'Description', array('class' => 'col-md-3 control-label')); !!}
              <div class="col-md-9">
                <div class="input-group">
                  {!! Form::text('description', $data->description, array('id' => 'description', 'class' => 'form-control', 'placeholder' => 'Description')) !!}
                  <div class="input-group-append">
                    <label for="description" class="input-group-text">
                      SEO
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group has-feedback row {{ $errors->has('canonical') ? ' has-error ' : '' }}">
              {!! Form::label('canonical', 'Canonical', array('class' => 'col-md-3 control-label')); !!}
              <div class="col-md-9">
                <div class="input-group">
                  {!! Form::text('canonical', $data->canonical, array('id' => 'canonical', 'class' => 'form-control', 'placeholder' => 'Canonical')) !!}
                  <div class="input-group-append">
                    <label for="canonical" class="input-group-text">
                      SEO
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group has-feedback row {{ $errors->has('url') ? ' has-error ' : '' }}">
              {!! Form::label('url', 'URL', array('class' => 'col-md-3 control-label')); !!}
              <div class="col-md-9">
                <div class="input-group">
                  {!! Form::text('url', $data->url, array('id' => 'url', 'class' => 'form-control', 'placeholder' => 'URL')) !!}
                  <div class="input-group-append">
                    <label for="url" class="input-group-text">
                      SEO
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group has-feedback row {{ $errors->has('property') ? ' has-error ' : '' }}">
              {!! Form::label('property', 'Property', array('class' => 'col-md-3 control-label')); !!}
              <div class="col-md-9">
                <div class="input-group">
                  {!! Form::text('property', $data->property, array('id' => 'property', 'class' => 'form-control', 'placeholder' => 'Property')) !!}
                  <div class="input-group-append">
                    <label for="property" class="input-group-text">
                      SEO
                    </label>
                  </div>
                </div>
              </div>
            </div>
            {!! Form::button('Update SEO', array('class' => 'btn btn-success margin-bottom-1 mt-3 mb-3 float-right','type' => 'submit' )) !!}
          {!! Form::close() !!}
        </div>
      </div>
      
    </div>

    <div class="col-sm-12 mb-3">
      <div class="card">
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
                Edit Page Content
            </span>
            <div class="pull-right">
                <a href="{{ route('settings-seo') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to SEO">
                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                    Back to SEO
                </a>
            </div>
          </div>
        </div>
        <div class="card-body">
          {!! Form::open(array('route' => 'apgadm/settings/seo/update', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{ $data->id }}">
            <input type="hidden" name="type" value="content">
            {!! Form::textarea('content', $data->content, ['class' => 'editor']) !!}
            {!! Form::button('Update Content', array('class' => 'btn btn-success margin-bottom-1 mt-3 mb-3 float-right','type' => 'submit' )) !!}
          {!! Form::close() !!}
        </div>
      </div>
      
    </div>
  </div>
</div>

@endsection

@section('footer_scripts')

  <script>
    $(function(){

      CKEDITOR.replace('content', {
        allowedContent: true
      });

    });
  </script>


@endsection