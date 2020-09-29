@extends('layouts.app')

@section('template_title')
  Setting Numbers
@endsection

@section('content')
<div class="container">
  <div class="row">

    <div class="col-sm-12 mb-3">
      <div class="card">
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
              Numbers Settings
            </span>
          </div>
        </div>

        <div class="card-body">
          {!! Form::open(array('route' => 'apgadm/settings/numbers/update', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}

            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{$data->id}}">
            <div class="form-group">
              <label for="timezone">Timezone</label>
              <select class="form-control custom-select" name="timezone">
                <option value="{{$data->timezone}}" selected>{{$data->timezone}}</option>
                @foreach($timezone as $value)
                <option value="{{$value->timezone}}">{{$value->timezone}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="timezone">Countdown Stop</label>
              <!-- <input type="text" class="form-control" name="countdown_stop" value="{{ $data->countdown_stop }}"> -->
              <input type="time" id="default-picker" class="form-control" placeholder="Select time" name="countdown_stop" value="{{ $data->countdown_stop }}">
            </div>
            <div class="form-group">
              <label for="min_count_reload_time">Min count reload time</label>
              <input type="number" min="1" class="form-control" name="min_count_reload_time" id="min_count_reload_time" aria-describedby="helpId" value="{{ $data->min_count_reload_time }}">
              <small id="helpId" class="form-text text-muted">Minutes is used for the value. example 60 mean 1 hours.</small>
            </div>
            <div class="form-group">
              <label for="max_count_reload_time">Max count reload time</label>
              <input type="number" min="2" class="form-control" name="max_count_reload_time" id="max_count_reload_time" aria-describedby="helpId" value="{{ $data->max_count_reload_time }}">
              <small id="helpId" class="form-text text-muted">Minutes is used for the value. example 60 mean 1 hours.</small>
            </div>

            {!! Form::button('Update Settings', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}

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

    });
  </script>


@endsection