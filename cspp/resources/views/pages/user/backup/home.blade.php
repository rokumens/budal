@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection

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
        .dataTables_filter{
          display: none !important;
        }
    </style>
@endsection
@section('content')
<div class="container">
  @if($message = Session::get('success'))
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <strong>Success!</strong> {{ $message }}
      </div>
  @endif
  {!! Session::forget('success') !!}
</div>

<div class="card-body">
  @if(count($master_numbers))
    <div class="table-responsive users-table">
        @include('partials.search-items-form')
        <div class="row">
          <div class="col-md-6">
              {{--<div class="btn-group">
                  <button id="all" class="btn btn-outline-secondary filter">All</button>
                  <button id="notyet" class="btn btn-outline-secondary filter">Not contacted</button>
                  <button id="donyet" class="btn btn-outline-secondary filter">Contacted</button>
              </div>--}}
          </div>
          <div class="col-md-6">
              {!! Form::open([ 'url' => route('showpages'), 'method' => 'get', 'class' => 'pull-right' ]) !!}
                 {{--<select name="per_page" onchange="this.form.submit()" class="form-control input-sm">
                    <option value="">Show entries</option>
                    <option value="50" {{ $items->perPage() == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $items->perPage() == 100 ? 'selected' : '' }}>100</option>
                    <option value="150" {{ $items->perPage() == 150 ? 'selected' : '' }}>150</option>
                 </select>--}}
              {!! Form::close() !!}
          </div>
        </div>
        <div style="clear:both;"><br /></div>
        <table id="clients_table" class="table table-striped table-sm data-table display dataTable">
          <thead class="thead">
            <tr>
              <th>Bank Account Name</th>
              <th>Mobile</th>
              <th>Bank</th>
              <th>Bank Number</th>
              <th>Provider</th>
              <th>Merchant</th>
              <th>Contacted</th>
              <th>Connect Response</th>
              <th>Campaign Result</th>
              <th>Next Action</th>
              <th>Notes</th>
              <th>Username 1</th>
              <th>Tanggal</th>
              <th>Mobile 2</th>
              <th>Mobile 3</th>
              <th>Email 1</th>
              <th>Email 2</th>
              <th>Username 2</th>
              <th data-orderable="false">Action</th>
            </tr>
          </thead>

          {{ csrf_field() }}

          <tbody id="items_table_cs">
          @foreach($master_numbers as $singCSV)
            <tr>
              <td>{{$singCSV->bank_account_name}}</td>
              <td>{{$singCSV->mobile_1}}</td>
              <td>{{$singCSV->bank}}</td>
              <td>{{$singCSV->bank_account_number}}</td>
              <td>{{$singCSV->provider}}</td>
              <td>{{ empty($singCSV->merchant) ? "-" : substr($singCSV->merchant,0,10).'...' }}</td>
              <td>{{$singCSV->contacted==1 ? 'done':'not yet'}}</td>
              <td>{{$singCSV->connect_response}}</td>
              <td>{{$singCSV->campaign_result}}</td>
              <td>{{$singCSV->next_action}}</td>
              <td>{{ substr($singCSV->notes_1,0,10) }}</td>
              <td>{{$singCSV->username_1}}</td>
              <td>{{$singCSV->tanggal}}</td>
              <td>{{$singCSV->mobile_2}}</td>
              <td>{{$singCSV->mobile_3}}</td>
              <td>{{$singCSV->email_1}}</td>
              <td>{{$singCSV->email_2}}</td>
              <td>{{$singCSV->username_2}}</td>
              <td>
                  <a href="#" class="btn btn-sm btn-info btn-block editModalBtn" data-toggle="modal" data-id="{{$singCSV->id}}" data-contacted="{{$singCSV->contacted}}" data-notes="{{$singCSV->notes_1}}" data-connectresponsedata="{{$singCSV->connect_response_id}}" data-campaignresultdata="{{$singCSV->campaign_result_id}}" data-nextactiondata="{{$singCSV->next_action_id}}">Edit</a>
              </td>
            </tr>
           @endforeach
         </tbody>
         <tbody id="search_results"></tbody>
        </table>
      </div>
  @else
      @include('panels.welcome-panel')
  @endif
</div>

{{-- Modal --}}
<div id="editModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-md" style="max-width:800px !important;">
     {{ Form::open(array('method' => 'PUT','id'=>'classForm','class'=>'form-horizontal classFormUpdate')) }}
     {{ Form::hidden('items_id', '', array('id' => 'items-id','class'=>'items-id')) }}
     @csrf
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel2">Update contact</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body">
            <div class="form-group has-feedback row {{ $errors->has('contacted_chk') ? ' has-error ' : '' }}">
                {!! Form::label('contacted_chk', trans('Already contacted?'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                    <div class="input-group">
                      {{-- Form::checkbox('contacted_chk',true,false, array('id'=>'contacted_id', 'class'=> 'contacted_id')) --}}
                      <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input contacted_id" name="contacted_chk" id="contacted_id" />
                          <label class="custom-control-label" for="contacted_id"></label>
                      </div>
                    </div>
                </div>
            </div>
            <div class="form-group has-feedback row {{ $errors->has('connectresponseLabel') ? ' has-error ' : '' }}">
                {!! Form::label('connectresponseLabel', trans('Connect Response'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                    <div class="input-group">
                        <select name="connectresponse" id="connect_response" class="form-control input-sm connect_response" disabled>
                            @if ($connect_response)
                                <option value="">Choose connect response</option>
                                @foreach($connect_response as $singResponse)
                                    <option value="{{ $singResponse->id }}">{{ $singResponse->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group has-feedback row {{ $errors->has('campaignresultLabel') ? ' has-error ' : '' }}">
                {!! Form::label('campaignresultLabel', trans('Campaign Result'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                    <div class="input-group">
                        <select name="campaignresult" id="campaign_result" class="form-control input-sm campaign_result" disabled>
                            @if ($campaign_result)
                                <option value="">Choose campaign result</option>
                                @foreach($campaign_result as $singResult)
                                    <option value="{{ $singResult->id }}">{{ $singResult->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group has-feedback row {{ $errors->has('nextactionLabel') ? ' has-error ' : '' }}">
                {!! Form::label('nextactionLabel', trans('Next Action'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                    <div class="input-group">
                        <select name="nextaction" id="next_action" class="form-control input-sm next_action" disabled>
                            @if ($next_action)
                                <option value="">Choose next action</option>
                                @foreach($next_action as $singNext)
                                    <option value="{{ $singNext->id }}">{{ $singNext->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group has-feedback row {{ $errors->has('notes1') ? ' has-error ' : '' }}">
                {!! Form::label('notes1', trans('Notes'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                    <div class="input-group">
                        <textarea name="notes" class="form-control notes_id" id="notes_id" rows="3" disabled></textarea>
                    </div>
                </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary btn-save" disabled=d>
                <i aria-hidden="true" class="fa fa-fw fa-save"></i> Update
            </button>
         </div>
      </div>
    {{ Form::close() }}
   </div>
</div>

@endsection

@section('footer_scripts')
    @if ((count($master_numbers) > config('usersmanagement.datatablesJsStartCount')) && config('usersmanagement.enabledDatatablesJs'))
        @include('scripts.datatables')
    @endif

    @if(config('usersmanagement.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif

    @include('scripts.search-items-cs')

    {{-- for dataTables --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    {{-- for button column visibility --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    <style type="text/css">
      #clients_table_length{float:right;padding-right:15px;}
      #clients_table_filter{float:right;padding-right:30px;}
      .dataTables_info{margin:10px 10px;float:left;}
      .dataTables_paginate{margin:10px 10px; float:right;}
    }
    </style>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    {{-- buat button column visibility --}}
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
          $(".alert").first().hide().fadeIn(500).delay(2000).fadeOut(1000, function () { $(this).remove(); });
          $('#clients_table').DataTable( {
              dom: 'Blfrtip',
              buttons: [
                  {
                      extend: 'colvis',
                      text : '<i class="fa fa-eye"></i> Column',
                      titleAttr : 'Column visibility',
                      collectionLayout: 'fixed three-column',
                      postfixButtons: [ 'colvisRestore' ],
                      init: function(api, node, config) {
                         $(node).removeClass('dt-button').addClass("btn btn-outline-secondary .px-2");
                      }
                  }
              ],
              columnDefs: [
                  {
                      targets: [-2, -3, -4, -5 ,-6, -7, -8],
                      visible: false
                  }
              ],
              "lengthMenu": [[25, 50, 100, 150, -1], [25, 50, 100, 150, "All"]],
              "paging":   true,
              "pageLength"  : 25,
              "info":     false,
              //"searching": false,
              // "order": [[ 6, "desc" ]]
          } );

          //filtering button mana yg udah / belum di contacted.
          var dataTable = $('#clients_table').DataTable();
          $('#all').on('click', function () {
              dataTable.search('').columns().search('').draw();
          });
          $('#notyet').on('click', function () {
              dataTable.columns(6).search("not yet" ).draw();
          });
          $('#donyet').on('click', function () {
              dataTable.columns(6).search("done" ).draw();
          });
          $('.contacted_id').on('click', function(){
            if($('.contacted_id').is(':checked')){
              $('.connect_response').prop("disabled", false);
              $('.campaign_result').prop("disabled", false);
              $('.next_action').prop("disabled", false);
              $('.notes_id').prop("disabled", false);
              $('.btn-save').prop("disabled", false);

            }else{
              $('.connect_response').prop("disabled", true);
              $('.campaign_result').prop("disabled", true);
              $('.next_action').prop("disabled", true);
              $('.notes_id').prop("disabled", true);
              $('.btn-save').prop("disabled", true);
            }
          });
          // modal update
          $('.editModalBtn').click(function(){
            var id=$(this).data('id');
            var action ='{{URL::to('contacted-update')}}/'+id;
            var url = '{{URL::to('contacted-update')}}';
            //existing
            var contacted=$(this).data('contacted');
            var notes_val=$(this).data('notes');
            var connect_response_val=$(this).data('connectresponsedata');
            var campaign_result_val=$(this).data('campaignresultdata');
            var next_action_val=$(this).data('nextactiondata');
            $('.btn-save').click(function(){
              if($('.connect_response').val()==''){alert('Please choose Connect Response');return false;}
              if($('.campaign_result').val()==''){alert('Please choose Campaign Result');return false;}
              if($('.next_action').val()==''){alert('Please choose Next Action');return false;}
              return true;
            });
            $.ajax({
              url  : url,
              data: {'id': id},
              method: "get",
              success:function(data){
                  $('.classFormUpdate').attr('action',action);
                  $('#editModal').modal('show');
                  //existing
                  $('.contacted_id').prop('checked', contacted == 1); //will checked the checkbox if done contacted
                  $('.notes_id').val(notes_val);
                  $('.connect_response').val(connect_response_val);
                  $('.campaign_result').val(campaign_result_val);
                  $('.next_action').val(next_action_val);
              },
              error: function (xhr, textStatus, errorThrown) {
      						console.log(textStatus + ':' + errorThrown);
                  console.log('Error Berat: ' + xhr.responseText);  // luffy
        					console.log('Error Berat: ' + xhr.statusText); // luffy
        					console.log('Error Berat: ' + textStatus); // luffy
        					console.log('Error Berat: ' + error); // luffy
      				},
            });
          });
        });
    </script>

@endsection
