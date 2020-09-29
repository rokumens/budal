@extends('layouts.app')

@section('template_title')
  Pop Up Setting
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
                Pop Up Settings
            </span>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('apgadm/settings/popup/update') }}" method="post" role="form" class="needs-validation" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="form-group">
              <label for="popup_status">Status</label>
              <select class="form-control" name="popup_status" id="popup_status">
                <option value="1" {{$settings->popup_status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{$settings->popup_status == 0 ? 'selected' : '' }}>Nonactive</option>
              </select>
            </div>
            <div class="form-group">
              <label for="popup_timeout">Timeout</label>
              <input type="number" class="form-control" name="popup_timeout" id="popup_timeout" value="{{$settings->popup_timeout}}" aria-describedby="helpIdpopup_timeout" placeholder="Fill timeout">
              <small id="helpIdpopup_timeout" class="form-text text-muted">This determine when popup will show after page load in second. Example : 5 mean the popup will show after 5 second. 0 will instanly show the popup.</small>
            </div>
            <div class="form-group">
              <label for="">Pop Up Title</label>
              <input type="text" class="form-control" name="popup_title" id="popup_title" value="{{$settings->popup_title}}" aria-describedby="helpIdpopup_title" placeholder="Input popup title">
            </div>
            <div class="form-group">
              <label for="">Pop Up Content</label>
              <textarea name="popup_content" id="editor" class="editor">{{$settings->popup_content}}</textarea>
            </div>
            {!! Form::button('Update Settings', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
          </form>
        </div>
      </div>
    </div>
    
  </div>
</div>

@endsection

@section('footer_scripts')
<script>
  $(function(){

    CKEDITOR.replace('popup_content', {
      allowedContent: true
    });

  });
</script>
@endsection