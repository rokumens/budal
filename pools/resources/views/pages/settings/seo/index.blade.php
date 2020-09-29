@extends('layouts.app')

@section('template_title')
  SEO Settings
@endsection

@section('template_linked_css')
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
@endsection

@section('content')
<div class="container">
  <div class="row">

    <div class="col-sm-12 mb-3">
      <div class="card">
        {!! Form::open(array('route' => 'apgadm/settings/seo/store', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
                SEO
            </span>
          </div>
        </div>
        <div class="card-body">
            {!! csrf_field() !!}
            <div class="form-group has-feedback row {{ $errors->has('menu_name') ? ' has-error ' : '' }}">
              {!! Form::label('menu_name', 'Menu Name', array('class' => 'col-md-3 control-label')); !!}
              <div class="col-md-9">
                <div class="input-group">
                  {!! Form::text('menu_name', NULL, array('id' => 'menu_name', 'class' => 'form-control', 'placeholder' => 'Menu Name')) !!}
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
                  {!! Form::text('title', NULL, array('id' => 'title', 'class' => 'form-control', 'placeholder' => 'Title')) !!}
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
                  {!! Form::text('keyword', NULL, array('id' => 'keyword', 'class' => 'form-control', 'placeholder' => 'Keyword')) !!}
                  <div class="input-group-append">
                    <label for="keyword" class="input-group-text">
                      SEO
                    </label>
                  </div>
                </div>
                <small class="form-text text-muted">Use comma separator to add more keyword. Example: keyword1, keyword2, keyword3</small>
              </div>
            </div>
            <div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}">
              {!! Form::label('description', 'Description', array('class' => 'col-md-3 control-label')); !!}
              <div class="col-md-9">
                <div class="input-group">
                  {!! Form::text('description', NULL, array('id' => 'description', 'class' => 'form-control', 'placeholder' => 'Description')) !!}
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
                  {!! Form::text('canonical', NULL, array('id' => 'canonical', 'class' => 'form-control', 'placeholder' => 'Canonical')) !!}
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
                  {!! Form::text('url', NULL, array('id' => 'url', 'class' => 'form-control', 'placeholder' => 'URL')) !!}
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
                  {!! Form::text('property', NULL, array('id' => 'property', 'class' => 'form-control', 'placeholder' => 'Property')) !!}
                  <div class="input-group-append">
                    <label for="property" class="input-group-text">
                      SEO
                    </label>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
                Content
            </span>
          </div>
        </div>
        <div class="card-body">
          <textarea name="content" id="editor" class="editor"></textarea>
          {!! Form::button('Add SEO', array('class' => 'btn btn-success margin-bottom-1 mt-3 mb-3 float-right','type' => 'submit' )) !!}
        </div>
        {!! Form::close() !!}
      </div>
      
    </div>

    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">

          <div style="display: flex; justify-content: space-between; align-items: center;">

            <span id="card_title">
              All SEO list
            </span>
            

          </div>
        </div>

        <div class="card-body">

          <div class="table-responsive users-table">
            <table class="table table-striped table-sm data-table">
                <caption id="user_count">
                  {{ trans_choice('Showing all data', 1, ['userscount' => $seos->count()]) }}
                </caption>
                <thead class="thead">
                  <tr>
                    <th>No</th>
                    <th>Menu Name</th>
                    <th>Title</th>
                    <th>URL</th>
                    <th colspan="2">Action</th>
                  </tr>
                </thead>
                <tbody id="users_table">
                  @php
                    $no = 1;
                  @endphp
                  @foreach($seos as $value)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{$value->menu_name}}</td>
                      <td>{{$value->title}}</td>
                      <td>{{$value->url}}</td>
                      <td>
                        <a href="{{ url('apgadm/settings/seo/edit/'.$value->id) }}" class="btn btn-sm btn-success">Edit</a>
                      </td>
                      <td>
                        @if($value->menu_name != 'home' && $value->menu_name != 'result' && $value->menu_name != 'livedraw' && $value->menu_name != 'about' && $value->menu_name != 'contact')
                        <form action="{{route('apgadm/settings/seo/destroy')}}" method="POST">
                          @method('DELETE')
                          @csrf
                          <input type="hidden" name="id" value="{{ $value->id }}">
                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>               
                        </form>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tbody id="search_results"></tbody>
                @if(config('usersmanagement.enableSearchUsers'))
                    <tbody id="search_results"></tbody>
                @endif

            </table>

            @if(config('usersmanagement.enablePagination'))
              {{-- {{ $seos->links() }} --}}
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('modals.modal-delete')

@endsection

@section('footer_scripts')
  @if ((count($seos) > config('usersmanagement.datatablesJsStartCount')) && config('usersmanagement.enabledDatatablesJs'))
      @include('scripts.datatables')
  @endif
  @include('scripts.delete-modal-script')
  @include('scripts.save-modal-script')
  @if(config('usersmanagement.tooltipsEnabled'))
      @include('scripts.tooltips')
  @endif
  @if(config('usersmanagement.enableSearchUsers'))
      @include('scripts.search-users')
  @endif

  <script>
    $(function(){

      CKEDITOR.replace('content', {
        allowedContent: true
      });

    });
  </script>


@endsection