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

    </style>
    <link href="{{ asset('/vendor/techlab/smartwizard') }}/dist/css/smart_wizard.css" rel="stylesheet" type="text/css" /> 
    <link href="{{ asset('/vendor/techlab/smartwizard') }}/dist/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
    @include('scripts.tombol-kedip-outline-css')
@endsection
@section('content')
    
  <div class="content-header">
    @include('partials.flashdata')
  </div>

  <div class="content">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title">Database</h2>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-2">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="v-pills-dev-tab" data-toggle="pill" href="#v-pills-dev" role="tab" aria-controls="v-pills-dev" aria-selected="true">Truncate</a>
              <a class="nav-link" id="v-pills-info-tab" data-toggle="pill" href="#v-pills-info" role="tab" aria-controls="v-pills-info" aria-selected="true">Info Database</a>
              <a class="nav-link" id="v-pills-remake-tab" data-toggle="pill" href="#v-pills-remake" role="tab" aria-controls="v-pills-remake" aria-selected="true">Remake Existing Data</a>
              <a class="nav-link" id="v-pills-cache-tab" data-toggle="pill" href="#v-pills-cache" role="tab" aria-controls="v-pills-cache" aria-selected="true">Cache</a>
            </div>
          </div>
          <div class="col-md-10">
            <div class="tab-content" id="v-pills-tabContent">

              <div class="tab-pane fade show active" id="v-pills-dev" role="tabpanel" aria-labelledby="v-pills-dev-tab">
                <div class="container">
                  <p><strong>List table will get truncate:</strong></p>
                  <ul class="pl-3">
                    <li>index_master_numbers</li>
                    <li>master_numbers</li>
                    <li>new_numbers</li>
                    <li>assigned</li>
                    <li>contacted</li>
                    <li>interested</li>
                    <li>registered</li>
                    <li>check</li>
                    <li>reassign</li>
                    <li>players</li>
                    <li>trash</li>
                  </ul>
                </div>
                <a onclick="return confirm('Are you sure?');" class="btn btn-danger" href="{{ url('/devtools/database/truncate') }}">Truncate All</a>
                <a onclick="return confirm('Are you sure?');" class="btn btn-danger" href="{{ url('/devtools/database/truncate/1') }}">Truncate new numbers</a>
                <a onclick="return confirm('Are you sure?');" class="btn btn-danger" href="{{ url('/devtools/database/truncate/2') }}">Truncate assigned</a>
                <a onclick="return confirm('Are you sure?');" class="btn btn-danger" href="{{ url('/devtools/database/truncate/3') }}">Truncate contacted</a>
                <a onclick="return confirm('Are you sure?');" class="btn btn-danger" href="{{ url('/devtools/database/truncate/4') }}">Truncate interested</a>
                <a onclick="return confirm('Are you sure?');" class="btn btn-danger" href="{{ url('/devtools/database/truncate/5') }}">Truncate registered</a>
                <a onclick="return confirm('Are you sure?');" class="btn btn-danger" href="{{ url('/devtools/database/truncate/6') }}">Truncate check</a>
                <a onclick="return confirm('Are you sure?');" class="btn btn-danger" href="{{ url('/devtools/database/truncate/7') }}">Truncate reassign</a>
                <a onclick="return confirm('Are you sure?');" class="btn btn-danger" href="{{ url('/devtools/database/truncate/8') }}">Truncate players</a>
                <a onclick="return confirm('Are you sure?');" class="btn btn-danger" href="{{ url('/devtools/database/truncate/9') }}">Truncate trash</a>
                <a onclick="return confirm('Are you sure?');" class="btn btn-danger" href="{{ url('/devtools/database/truncate/10') }}">Truncate kurcaci</a>
              </div>

              <div class="tab-pane fade" id="v-pills-info" role="tabpanel" aria-labelledby="v-pills-info-tab">
                <div class="table-responsive users-table card">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>New Numbers</th>
                        <th>{{ $countNewNumbers }}</th>
                      </tr>
                      <tr>
                        <th>Assigned</th>
                        <th>{{ $countAssigned }}</th>
                      </tr>
                      <tr>
                        <th>Contacted</th>
                        <th>{{ $countContacted }}</th>
                      </tr>
                      <tr>
                        <th>Interested</th>
                        <th>{{ $countInterested }}</th>
                      </tr>
                      <tr>
                        <th>Registered</th>
                        <th>{{ $countRegistered }}</th>
                      </tr>
                      <tr>
                        <th>Check</th>
                        <th>{{ $countCheck }}</th>
                      </tr>
                      <tr>
                        <th>Re-assign</th>
                        <th>{{ $countReassign }}</th>
                      </tr>
                      <tr>
                        <th>Players</th>
                        <th>{{ $countPlayers }}</th>
                      </tr>
                      <tr>
                        <th>Trash</th>
                        <th>{{ $countTrash }}</th>
                      </tr>
                      <tr>
                        <th>Total</th>
                        <th>{{ $countTotal }}</th>
                      </tr>
                      <tr>
                        <th>Master Numbers</th>
                        <th>{{ $countMaster }}</th>
                      </tr>
                      <tr>
                        <th>Diff</th>
                        <th>{{ $countMaster-$countTotal }}</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="v-pills-remake" role="tabpanel" aria-labelledby="v-pills-remake-tab">

                <div id="smartwizard">
                  <ul>
                    <li><a href="#step-1">Step 1</a></li>
                    <li><a href="#step-2">Step 2</a></li>
                    <li><a href="#step-3">Step 3</a></li>
                    <li><a href="#step-4">Step 4</a></li>
                    {{-- is register is not exist in old database --}}
                    {{-- <li><a href="#step-5">Registered Players List<br /><small>Copy from master</small></a></li> --}}
                    <li><a href="#step-6">Step 5</a></li>
                    {{-- assign times problem, not existed in old  database --}}
                    {{-- <li><a href="#step-7">Re-assign List<br /><small>Copy from master</small></a></li> --}}
                    {{-- is_deposit not exist in old database --}}
                    {{-- <li><a href="#step-8">Lovely Players List<br /><small>Copy from master</small></a></li> --}}
                    {{-- need to recycle all old phone numbers --}}
                    {{-- <li><a href="#step-9">Trash List<br /><small>Copy from master</small></a></li> --}}
                  </ul>
                  <div class="sw-container tab-content" style="min-height: 190.6px;">
                    <div id="step-1" class="tab-pane step-content">
                      <h3 class="border-bottom border-gray pb-2">New Numbers List<br /><small>Copy from master</small></h3>
                      <a href="{{ url('/devtools/database/step_1') }}" class="btn btn-primary mt-3">Button</a>
                    </div>
                    <div id="step-2" class="tab-pane step-content">
                      <h3 class="border-bottom border-gray pb-2">Assigned List<br /><small>Copy from master</small></h3>
                      <a href="{{ url('/devtools/database/step_2') }}" class="btn btn-primary mt-3">Button</a>
                    </div>
                    <div id="step-3" class="tab-pane step-content">
                      <h3 class="border-bottom border-gray pb-2">Contacted List<br /><small>Copy from master</small></h3>
                      <a href="{{ url('/devtools/database/step_3') }}" class="btn btn-primary mt-3">Button</a>
                    </div>
                    <div id="step-4" class="tab-pane step-content">
                      <h3 class="border-bottom border-gray pb-2">Interested Players List<br /><small>Copy from master</small></h3>
                      <a href="{{ url('/devtools/database/step_4') }}" class="btn btn-primary mt-3">Button</a>
                    </div>
                    <div id="step-6" class="tab-pane step-content">
                      <h3 class="border-bottom border-gray pb-2">Leader Check List<br /><small>Copy from master</small></h3>
                      <a href="{{ url('/devtools/database/step_5') }}" class="btn btn-primary mt-3">Button</a>
                    </div>
                  </div>
                </div>

              </div>

              <div class="tab-pane fade" id="v-pills-cache" role="tabpanel" aria-labelledby="v-pills-cache-tab">
                <div class="container">
                <a class="btn btn-danger" href="{{ url('/devtools/database/cache_flush') }}">Cache: flush</a>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('footer_scripts')
  <script type="text/javascript" src="{{ asset('/vendor/techlab/smartwizard') }}/dist/js/jquery.smartWizard.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $('#smartwizard').smartWizard({
        selected: 0,
        theme: 'arrows',
        transitionEffect:'fade',
        showStepURLhash: true,
        toolbarSettings: {
          showNextButton : false,
          showPreviousButton : false,
          toolbarExtraButtons : [
            $('<a href="{{ url("/devtools/database/bot_step") }}"></a>').html('<i class="fas fa-robot"></i> Bot Excute').addClass('btn btn-info'),
          ],
        },
        anchorSettings: {
          anchorClickable : true,
          enableAllAnchors : true,
          removeDoneStepOnNavigateBack : true,
        },
      });
    });
  </script>
@endsection
