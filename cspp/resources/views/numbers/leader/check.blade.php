@extends('layouts.app')
@section('template_linked_css')
    <style type="text/css" media="screen">
        .users-table {
            border: 0;
        }
        .users-table tr td:first-child {
            padding-left: 25px;
        }
        .users-table tr td:last-child {
            padding-right: 25px;
        }
        .users-table.table-responsive,
        .users-table.table-responsive table {
            margin-bottom: 0;
        }
        #clients_ajax_table_server_side_filter{
            display:none !important;
        }
        .delete-all{
            padding: .1rem .2rem;
            position:relative;
            bottom: 5px;
        }

        .dropdown-submenu {
          position: relative;
        }

        .dropdown-submenu .dropdown-menu {
          top: 0;
          left: 100%;
          margin-top: -1px;
        }

        /* rotate caret on hover */
        .dropdown-menu > li > a:hover:after {
            text-decoration: underline;
            transform: rotate(-90deg);
        }
        .delete-all{  
          padding: .1rem .2rem;  position:relative;  bottom: 5px;  
        }
    </style>
    @include('scripts.tombol-kedip-outline-css')
@endsection
@section('content')
    
  <div class="content-header">
    {{-- Flashdata --}}
    @include('partials.flashdata')
  </div>

  <div class="content">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title">Check</h2>
      </div>
      <div class="card-body">
        <div class="row">
          
          @can('change-cs-check')
          <div class="col-md-4">
            <select class="custom-select form-control assignto" name="role" id="role" data-style="btn-default btn-lg">
                <option value="">Change CS</option>
                @if ($roles)
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->nik }} - {{ $role->name }}</option>
                    @endforeach
                @endif
            </select>
          </div>
          @else
          <div class="col-md-4"></div>
          @endcan

          {{-- partial search and date filter --}}
          @include('partials.search-number-form')
        </div>
        @include('partials.filter')
        <div class="users-table">
          <table id="clients_ajax_table_server_side" class="table table-striped table-bordered" style="width:100%;">
            <thead>
              <tr>
                @can('change-cs-check')
                <th data-orderable="false">
                  <div class="custom-control custom-checkbox" style="left: 5px;">
                    <input type="checkbox" class="custom-control-input" id="check_all" />
                    <label class="custom-control-label" for="check_all"></label>
                  </div>
                </th>
                @endcan
                <th>Number</th>
                <th>Web Category</th>
                <th>Game Category</th>
                @can('change-cs-check')
                <th>Change CS</th>
                @endcan
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="numbers_table"></tbody>
            <tbody id="search_results"></tbody>
          </table>
        </div>
  
      </div>
    </div>
  </div>
@endsection

@section('after_scripts')
{{-- Modal view --}}
<div id="viewModal" class="modal fade bs-example-modal-sm\" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog modal-md" style="max-width:800px !important;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          loading data...
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">

        <main role="main" class="container">
          <div class="is_cs_exist"></div>
          <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded box-shadow">
            <div class="lh-100">
              <h6 id="phone" class="mb-0 text-white lh-100">loading data...</h6>
            </div>
          </div>

          <div class="my-3 p-3 bg-white rounded box-shadow">
            <h6 class="border-bottom border-gray pb-2 mb-0">Assigned</h6>
            <div class="media text-muted pt-3">
              <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
              <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark">Assigned times</strong>
                <span id="assigned_times">loading data...</span>
              </p>
            </div>
          </div>

          <div class="my-3 p-3 bg-white rounded box-shadow">
            <h6 class="border-bottom border-gray pb-2 mb-0">Contacted</h6>
            <div class="media text-muted pt-3">
              <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
              <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark">contacted by</strong>
                <span id="contacted_by">loading data...</span>
              </p>
            </div>
            <div class="media text-muted pt-3">
              <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
              <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark">contacted times</strong>
                <span id="contacted_times">loading data...</span>
              </p>
            </div>
            <div class="media text-muted pt-3">
              <img data-src="holder.js/32x32?theme=thumb&bg=e83e8c&fg=e83e8c&size=1" alt="" class="mr-2 rounded">
              <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark">Contacted date</strong>
                <span id="contacted_date">loading data...</span>
              </p>
            </div>
            <div class="media text-muted pt-3">
              <img data-src="holder.js/32x32?theme=thumb&bg=6f42c1&fg=6f42c1&size=1" alt="" class="mr-2 rounded">
              <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark">Connect response by CS</strong>
                <span id="connect_response_cs">loading data...</span>
              </p>
            </div>
            <div class="media text-muted pt-3">
              <img data-src="holder.js/32x32?theme=thumb&bg=6f42c1&fg=6f42c1&size=1" alt="" class="mr-2 rounded">
              <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark">Player status</strong>
                <span id="campaign_result">loading data...</span>
              </p>
            </div>
            <div class="media text-muted pt-3">
              <img data-src="holder.js/32x32?theme=thumb&bg=6f42c1&fg=6f42c1&size=1" alt="" class="mr-2 rounded">
              <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark">Note by CS</strong>
                <span id="note_contacted">loading data...</span>
              </p>
            </div>
          </div>

          <div class="my-3 p-3 bg-white rounded box-shadow">
            <h6 class="border-bottom border-gray pb-2 mb-0">Phone number detail</h6>
            <div class="media text-muted pt-3">
              <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
              <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark">email</strong>
                <span id="email">loading data...</span>
              </p>
            </div>
            <div class="media text-muted pt-3">
              <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
              <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark">category web</strong>
                <span id="category_web">loading data...</span>
              </p>
            </div>
            <div class="media text-muted pt-3">
              <img data-src="holder.js/32x32?theme=thumb&bg=e83e8c&fg=e83e8c&size=1" alt="" class="mr-2 rounded">
              <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark">category game</strong>
                <span id="category_game">loading data...</span>
              </p>
            </div>
          </div>
          
        </main>
      </div>
    </div>
  </div>
</div>

{{-- Modal edit --}}
<div id="editModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog modal-md" style="max-width:800px !important;">
    {{ Form::open(array('method' => 'PUT','id'=>'classForm','class'=>'form-horizontal classFormUpdate')) }}
    {{ Form::hidden('master_numbers_id', '', array('id' => 'master_numbers_id','class'=>'master_numbers_id')) }}
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel2">Update</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group has-feedback row {{ $errors->has('connectresponse') ? ' has-error ' : '' }}">
            {!! Form::label('connectresponse', trans('Connect Response'), array('class' => 'col-md-3 control-label')); !!}
            <div class="col-md-9">
              <div class="input-group">
                  <select name="connectresponse" id="connectresponse" class="form-control input-sm connect_response" required>
                      @if ($connect_response)
                          <option value="">Choose connect response</option>
                          @foreach($connect_response as $singResponse)
                              <option value="{{ $singResponse->id }}">{{ $singResponse->name }}</option>
                          @endforeach
                      @endif
                  </select>
              </div>
              <small class="form-text responseDesc" style="font-style: italic;"></small>
            </div>
          </div>
          <div class="form-group has-feedback row {{ $errors->has('note_check') ? ' has-error ' : '' }}">
            {!! Form::label('note_check', trans('Notes'), array('class' => 'col-md-3 control-label hide_note')); !!}
            <div class="col-md-9">
                <div class="input-group">
                    <textarea name="note_check" class="form-control hide_note" id="note_check" rows="3" placeholder="Tell us your call result with this number..." required></textarea>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-save">
              <i aria-hidden="true" class="fa fa-fw fa-save"></i> Update
          </button>
        </div>
    </div>
  {{ Form::close() }}
  </div>
</div>
@endsection

@section('footer_scripts')
  {{-- @if (config('usersmanagement.enabledDatatablesJs'))
      @include('scripts.datatables')
  @endif --}}

  @include("scripts.numbers.$pageName")
  {{-- @if(config('usersmanagement.tooltipsEnabled'))
      @include('scripts.tooltips')
  @endif --}}

@endsection
