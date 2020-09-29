@extends('layouts.app')

@section('template_title')
  General Setting
@endsection

@section('template_linked_css')
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha256-rByPlHULObEjJ6XQxW/flG2r+22R5dKiAoef+aXWfik=" crossorigin="anonymous" />
@endsection

@section('content')
<div class="container">
  <div class="row">

    <div class="col-sm-12 mb-3">
      <div class="card">
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
                General Settings
            </span>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('apgadm/settings/general/update') }}" method="post" role="form" class="needs-validation" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label for="logo">Launching Date</label>
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control datepicker" name="launching_date" id="launching_date" placeholder="Launching date" aria-describedby="helplaunching_date" value="{{ $settings->launching_date }}">
                </div>
              </div>
            </div>
            <input type="hidden" name="type" value="general">
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label for="logo">Logo</label>
                </div>
                <div class="col-md-8">
                  <input type="file" class="form-control-file" name="logo" id="logo" placeholder="logo" aria-describedby="helplogo">
                  <small id="helplogo" class="form-text text-muted">Preview:</small>
                  @if($settings->logo)
                  <img src="{{ asset('public/upload/'.$settings->logo) }}" width="100px" height="100px" class="img-thumbnail" alt="logo">
                  @else
                  <img src="{{ asset('public/upload/default.png') }}" width="100px" height="100px" class="img-thumbnail" alt="logo">
                  @endif
                </div>
              </div>
            </div>
            {{-- <div class="form-group">
              <div class="row">
                <div class="col-md-4 my-auto">
                  <label for="logo_height">Logo Height</label>
                </div>
                <div class="col-md-8">
                  <input type="number" class="form-control" value="{{$settings->logo_height}}" name="logo_height" id="logo_height" aria-describedby="helplogo_height" placeholder="">
                  <small id="helplogo_height" class="form-text text-muted">Size value based on pixel. Leave it blank if you use dafault image size.</small>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4 my-auto">
                  <label for="logo_width">Logo Width</label>
                </div>
                <div class="col-md-8">
                  <input type="number" class="form-control" value="{{$settings->logo_width}}" name="logo_width" id="logo_width" aria-describedby="helplogo_width" placeholder="">
                  <small id="helplogo_width" class="form-text text-muted">Size value based on pixel. Leave it blank if you use dafault image size.</small>
                </div>
              </div>
            </div> --}}
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label for="background">Background</label>
                </div>
                <div class="col-md-8">
                  <input type="file" class="form-control-file" name="background" id="background" placeholder="background" aria-describedby="helpbackground">
                  <small id="helpbackground" class="form-text text-muted">Preview:</small>
                  @if($settings->background)
                  <img src="{{ asset('public/upload/'.$settings->background) }}" class="img-thumbnail" alt="background">
                  @else
                  <img src="{{ asset('public/upload/default.png') }}" class="img-thumbnail" alt="background">
                  @endif
                </div>
              </div>
            </div>
            {!! Form::button('Update Settings', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
          </form>
        </div>
      </div>
    </div>

    {{-- Header scripts setting --}}
    <div class="col-sm-12 mb-3">
      <div class="card">
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
              Footer settings
            </span>
          </div>
        </div>
        <div class="card-body">
          {!! Form::open(array('route' => 'apgadm/settings/general/update', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
            {!! csrf_field() !!}
            <input type="hidden" name="type" value="footer">
            {{-- <div class="form-group">
              <label for="footer1_color">Footer 1 Background color</label>
              <select class="form-control" name="footer1_color" id="footer1_color">
                <option value="primary" {{ $footers[0]->color == 'primary' ? 'selected' : NULL }}>Blue</option>
                <option value="info" {{ $footers[0]->color == 'info' ? 'selected' : NULL }}>Sky Blue</option>
                <option value="success" {{ $footers[0]->color == 'success' ? 'selected' : NULL }}>Green</option>
                <option value="warning" {{ $footers[0]->color == 'warning' ? 'selected' : NULL }}>Yellow</option>
                <option value="danger" {{ $footers[0]->color == 'danger' ? 'selected' : NULL }}>Red</option>
                <option value="dark" {{ $footers[0]->color == 'dark' ? 'selected' : NULL }}>Dark</option>
                <option value="white" {{ $footers[0]->color == 'white' ? 'selected' : NULL }}>White</option>
              </select>
            </div> --}}
            <div class="form-group">
              <label for="footer1_content">Footer 1 Content</label>
              <textarea class="form-control" name="footer1_content" id="footer1_content" rows="3">{{ $footers[0]->content }}</textarea>
            </div>
            <hr>
            {{-- <div class="form-group">
              <label for="footer2_color">Footer 2 Background color</label>
              <select class="form-control" name="footer2_color" id="footer2_color">
                <option value="primary" {{ $footers[1]->color == 'primary' ? 'selected' : NULL }}>Blue</option>
                <option value="info" {{ $footers[1]->color == 'info' ? 'selected' : NULL }}>Sky Blue</option>
                <option value="success" {{ $footers[1]->color == 'success' ? 'selected' : NULL }}>Green</option>
                <option value="warning" {{ $footers[1]->color == 'warning' ? 'selected' : NULL }}>Yellow</option>
                <option value="danger" {{ $footers[1]->color == 'danger' ? 'selected' : NULL }}>Red</option>
                <option value="dark" {{ $footers[1]->color == 'dark' ? 'selected' : NULL }}>Dark</option>
                <option value="white" {{ $footers[1]->color == 'white' ? 'selected' : NULL }}>White</option>
              </select>
            </div> --}}
            <div class="form-group">
              <label for="footer2_content">Footer 2 Content</label>
              <textarea class="form-control" name="footer2_content" id="footer2_content" rows="3">{{ $footers[1]->content }}</textarea>
            </div>
            <hr>
            {{-- <div class="form-group">
              <label for="footer3_color">Footer 3 Background color</label>
              <select class="form-control" name="footer3_color" id="footer3_color">
                <option value="primary" {{ $footers[2]->color == 'primary' ? 'selected' : NULL }}>Blue</option>
                <option value="info" {{ $footers[2]->color == 'info' ? 'selected' : NULL }}>Sky Blue</option>
                <option value="success" {{ $footers[2]->color == 'success' ? 'selected' : NULL }}>Green</option>
                <option value="warning" {{ $footers[2]->color == 'warning' ? 'selected' : NULL }}>Yellow</option>
                <option value="danger" {{ $footers[2]->color == 'danger' ? 'selected' : NULL }}>Red</option>
                <option value="dark" {{ $footers[2]->color == 'dark' ? 'selected' : NULL }}>Dark</option>
                <option value="white" {{ $footers[2]->color == 'white' ? 'selected' : NULL }}>White</option>
              </select>
            </div> --}}
            <div class="form-group">
              <label for="footer3_content">Footer 3 Content</label>
              <textarea class="form-control" name="footer3_content" id="footer3_content" rows="3">{{ $footers[2]->content }}</textarea>
            </div>
            <hr>
            {{-- <div class="form-group">
              <label for="footer4_color">Footer 4 Background color</label>
              <select class="form-control" name="footer4_color" id="footer4_color">
                <option value="primary" {{ $footers[3]->color == 'primary' ? 'selected' : NULL }}>Blue</option>
                <option value="info" {{ $footers[3]->color == 'info' ? 'selected' : NULL }}>Sky Blue</option>
                <option value="success" {{ $footers[3]->color == 'success' ? 'selected' : NULL }}>Green</option>
                <option value="warning" {{ $footers[3]->color == 'warning' ? 'selected' : NULL }}>Yellow</option>
                <option value="danger" {{ $footers[3]->color == 'danger' ? 'selected' : NULL }}>Red</option>
                <option value="dark" {{ $footers[3]->color == 'dark' ? 'selected' : NULL }}>Dark</option>
                <option value="white" {{ $footers[3]->color == 'white' ? 'selected' : NULL }}>White</option>
              </select>
            </div> --}}
            <div class="form-group">
              <label for="footer4_content">Footer 4 Content</label>
              <textarea class="form-control" name="footer4_content" id="footer4_content" rows="3">{{ $footers[3]->content }}</textarea>
            </div>
            <hr>
            {!! Form::button('Update', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>

    {{-- Header scripts setting --}}
    <div class="col-sm-12 mb-3">
      <div class="card">
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
                Header Scripts
            </span>
          </div>
        </div>
        <div class="card-body">
          {!! Form::open(array('route' => 'apgadm/settings/general/store', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
            {!! csrf_field() !!}
            <input type="hidden" name="type" value="script">
            <div class="form-group">
              <label for="name">Script name</label>
              <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="input script name">
            </div>
            <div class="form-group">
              <label for="script">Script syntax in the head section</label>
              <textarea class="form-control" name="script" id="script" rows="10" placeholder="Put your <script> or <meta> here..."></textarea>
            </div>
            {!! Form::button('Add Script', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
          {!! Form::close() !!}
        </div>
        <div class="card-body">
          <div class="row">
            <div class="cl-md-12"></div>
            <div class="cl-md-12"></div>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Name</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($scripts as $value)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $value->name }}</td>
                <td>{!! $value->active == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Nonactive</span>' !!}</td>
                <td>
                  {{ $value->priority }}
                  <div class="btn-group ml-2" role="group" aria-label="Basic example">
                    <a href="{{ url("apgadm/settings/general/level/$value->id/up") }}"><span class="btn badge badge-primary">Up</span></a>
                    <a href="{{ url("apgadm/settings/general/level/$value->id/down") }}"><span class="btn badge badge-danger">Down</span></a>
                  </div>
                </td>
                <td>
                  @if($value->active)
                  <a href='{{ url("apgadm/settings/general/terminator/$value->id") }}' class='btn btn-sm btn-outline-danger'>Dectivate</a>
                  @else
                  <a href='{{ url("apgadm/settings/general/terminator/$value->id") }}' class='btn btn-sm btn-outline-success'>Activate</a>
                  @endif
                  <a href="{{ url("apgadm/settings/general/edit/$value->id") }}" class="btn btn-sm btn-success">Edit</a>
                  <a href="{{ url("apgadm/settings/general/delete/$value->id/script") }}" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-danger">Delete</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer">
          {{ $scripts->links() }}
        </div>
      </div>
    </div>

    {{-- Social media setting --}}
    <div class="col-sm-12 mb-3">
      <div class="card">
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
              Social Media
            </span>
          </div>
        </div>
        <div class="card-body">
          {!! Form::open(array('route' => 'apgadm/settings/general/store', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
            {!! csrf_field() !!}
            <input type="hidden" name="type" value="social">
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control form-control-sm" name="title" id="title" placeholder="title">
            </div>
            <div class="form-group">
              <label for="url">URL</label>
              <input type="url" class="form-control form-control-sm" name="url" id="url" placeholder="url">
            </div>
            <div class="form-group">
              <label for="icon">Icon</label>
              <input type="text" class="form-control form-control-sm" name="icon" id="icon" aria-describedby="helpIdicon" placeholder="icon">
              <small id="helpIdicon" class="form-text text-muted">Icon used fontawesome 4. Example: "fa fa-facebook" for <i class="fa fa-facebook"></i> (facebook icon). you can get more icon in <a href="https://fontawesome.com/v4.7.0/icons/" target="__blank">here</a></small>
            </div>
            {!! Form::button('Add Social Media', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
          {!! Form::close() !!}
        </div>
        <div class="card-body">
          <div class="row">
            <div class="cl-md-12"></div>
            <div class="cl-md-12"></div>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Title</th>
                <th>URL</th>
                <th>Icon</th>
                <th>Preview</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($socials as $value)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $value->title }}</td>
                <td>{{ $value->url }}</td>
                <td>{{ $value->icon }}</td>
                <td><i class="{!! $value->icon !!}"></i></td>
                <td>
                  <button type="button" data-id="{{ $value->id }}" class="btn btn-sm btn-success edit" data-toggle="modal" data-target="#modelId">Edit</button>
                  <a href="{{ url("apgadm/settings/general/delete/$value->id/social") }}" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-danger">Delete</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer">
          {{ $socials->links() }}
        </div>
      </div>
    </div>
    
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Social Media</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::open(array('route' => 'apgadm/settings/general/update', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
      <div class="modal-body">
        {!! csrf_field() !!}
        <input type="hidden" name="type" value="social">
        <input type="hidden" name="id" id="idSocial">
        <div class="form-group">
          <label for="titleEdit">Title</label>
          <input type="text" class="form-control form-control-sm title" name="title" id="titleEdit" placeholder="title">
        </div>
        <div class="form-group">
          <label for="urlEdit">URL</label>
          <input type="url" class="form-control form-control-sm url" name="url" id="urlEdit" placeholder="url">
        </div>

        <div class="form-group">
          <label for="iconEdit">Icon</label>
          <div class="input-group">
            <input type="text" class="form-control form-control-sm icon" name="icon" id="iconEdit" aria-describedby="helpIdicon" placeholder="icon">
            <div class="input-group-append">
              <span class="input-group-text"><i id="iconPreview"></i></span>
            </div>
          </div>
          <small id="helpIdicon" class="form-text text-muted">Icon used fontawesome 4. Example: "fa fa-facebook" for <i class="fa fa-facebook"></i> (facebook icon). you can get more icon in <a href="https://fontawesome.com/v4.7.0/icons/" target="__blank">here</a></small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

@endsection

@section('footer_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha256-KM512VNnjElC30ehFwehXjx1YCHPiQkOPmqnrWtpccM=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function () {
    $( ".datepicker" ).datepicker({
      dateFormat : 'yy-mm-dd'
    });

    CKEDITOR.replace('footer1_content', {
      allowedContent: true
    });

    CKEDITOR.replace('footer2_content', {
      allowedContent: true
    });

    CKEDITOR.replace('footer3_content', {
      allowedContent: true
    });

    CKEDITOR.replace('footer4_content', {
      allowedContent: true
    });

    $('.edit').click(function(){
      let id = $(this).data('id');
      $.ajax({
        type: "post",
        url: "{{ url('apgadm/settings/general/ajaxEdit') }}",
        data: {
          id:id
        },
        dataType: "json",
        success: function (response) {
          $('#iconPreview').attr('class', response.icon);
          $('#idSocial').val(response.id);
          $('#titleEdit').val(response.title);
          $('#urlEdit').val(response.url);
          $('#iconEdit').val(response.icon);
        }
      });
    });

  });
</script>
@endsection