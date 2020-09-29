@extends('layouts.app')

@section('template_title')
    {!! trans('usersmanagement.editing-user', ['name' => $contact->name]) !!}
@endsection

@section('template_linked_css')
    <style type="text/css">
        .pw-change-container {
            display: none;
        }
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Editing Contact
                            <div class="pull-right">
                                <a href="{{ route('home') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ trans('usersmanagement.tooltips.back-users') }}">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('route' => ['home.update', $contact->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}

                            {!! csrf_field() !!}

                            <div class="form-group has-feedback row {{ $errors->has('contacted_chk') ? ' has-error ' : '' }}">
                                {!! Form::label('contacted_chk', trans('Already contacted?'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                      <input type="checkbox" name="contacted_chk" value="{{ ($contact->contacted==1) ? 1:0 }}" {{ ($contact->contacted==1) ? 'checked':'' }}>
                                    </div>
                                    @if($errors->has('notes_1'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('contacted_chk') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback row {{ $errors->has('notes1') ? ' has-error ' : '' }}">
                                {!! Form::label('notes1', trans('Notes 1'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('notes1', $contact->notes_1, array('id' => 'notes_1', 'class' => 'form-control', 'placeholder' => trans('Type your notes here...'))) !!}
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="name">
                                                <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @if($errors->has('notes_1'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('notes_1') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    {!! Form::button(trans('forms.save-changes'), array('class' => 'btn btn-success btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.edit_user__modal_text_confirm_title'),'style'=>'float:right;', 'data-message' => trans('modals.edit_user__modal_text_confirm_message'))) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-save')

@endsection

@section('footer_scripts')
  @include('scripts.save-modal-script')
  @include('scripts.check-changed')
@endsection
