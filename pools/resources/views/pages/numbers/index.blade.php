@extends('layouts.app')

@section('template_title')
  Numbers
@endsection

@section('template_linked_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
@endsection

@section('content')
<div class="container">
  <div class="row">

    <div class="col-sm-12 mb-3">
      <div class="card">
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
                Add New Number
            </span>
          </div>
        </div>

        <div class="card-body">
          {!! Form::open(array('route' => 'apgadm/numbers/store', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}

            {!! csrf_field() !!}

            <div class="form-group has-feedback row {{ $errors->has('number') ? ' has-error ' : '' }}">
              {!! Form::label('number', '1st Prize', array('class' => 'col-md-3 control-label')); !!}
              <div class="col-md-9">
                <div class="input-group">
                  {!! Form::text('number', NULL, array('id' => 'number', 'class' => 'form-control', 'placeholder' => 'Put number for 1st prize...')) !!}

                  <div class="input-group-append">
                    <label for="number" class="input-group-text">
                      <i class="fa fa-fw fa-plus-square-o" aria-hidden="true"></i>
                    </label>
                  </div>
                </div>
                @if ($errors->has('number'))
                  <span class="help-block">
                    <strong>{{ $errors->first('number') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group has-feedback row {{ $errors->has('date_for_number') ? ' has-error ' : '' }}">
              {!! Form::label('date_for_number', 'Date', array('class' => 'col-md-3 control-label')); !!}
              <div class="col-md-9">
                <div class="input-group">
                  {!! Form::text('date_for_number', NULL, array('id' => 'date_for_number', 'class' => 'form-control datepicker', 'placeholder' => 'Choose date...', 'data-date-end-date' => "+1d", 'readonly' => true)) !!}

                  <div class="input-group-append">
                    <label for="date_for_number" class="input-group-text">
                      <i class="fa fa-fw fa-calendar" aria-hidden="true"></i>
                    </label>
                  </div>
                </div>
                @if ($errors->has('date_for_number'))
                  <span class="help-block">
                    <strong>{{ $errors->first('date_for_number') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            {!! Form::button('Generate Number', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}

          {!! Form::close() !!}
        </div>
      </div>
      
    </div>

    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">

          <div style="display: flex; justify-content: space-between; align-items: center;">

            <span id="card_title">
              Showing All 1st Prize Number
            </span>

          </div>
        </div>

        <div class="card-body">

          {{-- @if(config('usersmanagement.enableSearchUsers'))
            @include('partials.search-numbers-form')
          @endif --}}

          <div class="table-responsive users-table">
            <table class="table table-striped table-sm data-table">
                <caption id="user_count">
                  {{ trans_choice('Showing all data', 1, ['userscount' => $numbers->count()]) }}
                </caption>
                <thead class="thead">
                  <tr>
                    <th>No</th>
                    <th>Number</th>
                    <th>For Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="users_table">
                  @php
                    $no = 1;
                  @endphp
                  @foreach($numbers as $value)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{$value->number}}</td>
                      <td>{{date('d F Y', strtotime($value->date_for_number))}}</td>
                      <td>
                        <a class="btn btn-sm btn-success" href="{{ url('apgadm/prize/'.$value->draw_id) }}" title="View All Prize">View All Prize</a>
                        @if (strtotime(date('Y-m-d H:i:s')) < strtotime($value->time_show))
                        <a class="btn btn-sm btn-info editButton" href="#edit" data-id="{{ $value->id }}" data-toggle="modal" data-target="#modalEdit" title="Edit">Edit</a>
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
              {{ $numbers->links() }}
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('modals.modal-delete')

<!-- Modal edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEdit" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Number</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::open(array('route' => 'apgadm/numbers', 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}
      <div class="modal-body">

          {!! csrf_field() !!}

          <input type="hidden" name="id" id="idEdit">

          <div class="form-group has-feedback row {{ $errors->has('number') ? ' has-error ' : '' }}">
            {!! Form::label('numberEdit', 'Number', array('class' => 'col-md-3 control-label')); !!}
            <div class="col-md-9">
              <div class="input-group">
                {!! Form::text('number', NULL, array('id' => 'numberEdit', 'class' => 'form-control', 'placeholder' => 'Number')) !!}

                <div class="input-group-append">
                  <label for="numberEdit" class="input-group-text">
                    <i class="fa fa-fw fa-plus-square-o" aria-hidden="true"></i>
                  </label>
                </div>
              </div>
              @if ($errors->has('number'))
                <span class="help-block">
                  <strong>{{ $errors->first('number') }}</strong>
                </span>
              @endif
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {!! Form::button('Edit', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
        </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>

@endsection

@section('footer_scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>

  @if ((count($numbers) > config('usersmanagement.datatablesJsStartCount')) && config('usersmanagement.enabledDatatablesJs'))
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

      $('.datepicker').datepicker({
        todayHighlight : true,
        format : 'yyyy-mm-dd'
      });

      // Ajax edit
      $('.editButton').click(function(){
        let id = $(this).data('id');
        $.ajax({
          type: "POST",
          url: "{{ url('apgadm/numbers') }}",
          data: {
            id : id,
          },
          dataType: "json",
          success: function (response) {
            $('#idEdit').val(response.id);
            $('#numberEdit').val(response.number);
          }
        });
      });

    });
  </script>


@endsection