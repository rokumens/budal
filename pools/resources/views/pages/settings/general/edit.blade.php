@extends('layouts.app')

@section('template_title')
  General setting edit
@endsection

@section('template_linked_css')
@endsection

@section('content')
<div class="container">
  <div class="row">

    <div class="col-sm-12 mb-3">
      <div class="card">
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
              Edit Header Script
            </span>
            <div class="pull-right">
                <a href="{{ route('settings-general') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to General Settings">
                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                    Back to General Settings
                </a>
            </div>
          </div>
        </div>
        <div class="card-body">
          {!! Form::open(array('route' => 'apgadm/settings/general/update', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
            {!! csrf_field() !!}
            <input type="hidden" name="type" value="script">
            <input type="hidden" name="id" value="{{$script->id}}">
            <div class="form-group">
              <label for="name">Script name</label>
              <input type="text" class="form-control form-control-sm" name="name" id="name" value="{{$script->name}}" placeholder="input script name">
            </div>
            <div class="form-group">
              <label for="script">Script syntax</label>
              <textarea class="form-control" name="script" id="script" rows="10" placeholder="put your script here">{{$script->script}}</textarea>
            </div>
            {!! Form::button('Update Script', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
          {!! Form::close() !!}
        </div>
      </div>
      
    </div>
  </div>
</div>

@endsection

@section('footer_scripts')
@endsection