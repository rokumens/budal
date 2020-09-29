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
    @include('scripts.tombol-kedip-outline-css')
@endsection
@section('content')
    
  <div class="content-header">
    @include('partials.flashdata')
  </div>

  <div class="content">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title">Settings</h2>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-2">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="v-pills-recycle-tab" data-toggle="pill" href="#v-pills-recycle" role="tab" aria-controls="v-pills-recycle" aria-selected="false">Recycle</a>
              <a class="nav-link" id="v-pills-constant-tab" data-toggle="pill" href="#v-pills-constant" role="tab" aria-controls="v-pills-constant" aria-selected="false">Constants</a>
              <a class="nav-link" id="v-pills-connect-response-tab" data-toggle="pill" href="#v-pills-connect-response" role="tab" aria-controls="v-pills-connect-response" aria-selected="false">Connect Response</a>
              <a class="nav-link" id="v-pills-campaign-result-tab" data-toggle="pill" href="#v-pills-campaign-result" role="tab" aria-controls="v-pills-campaign-result" aria-selected="false">Campaign Result</a>
              <a class="nav-link" id="v-pills-next-action-tab" data-toggle="pill" href="#v-pills-next-action" role="tab" aria-controls="v-pills-next-action" aria-selected="false">Next Action</a>
              <a class="nav-link" id="v-pills-category-web-tab" data-toggle="pill" href="#v-pills-category-web" role="tab" aria-controls="v-pills-category-web" aria-selected="false">Web Category</a>
              <a class="nav-link" id="v-pills-category-game-tab" data-toggle="pill" href="#v-pills-category-game" role="tab" aria-controls="v-pills-category-game" aria-selected="false">Game Category</a>
            </div>
          </div>
          <div class="col-md-10">
            <div class="tab-content" id="v-pills-tabContent">

              <div class="tab-pane fade show active" id="v-pills-recycle" role="tabpanel" aria-labelledby="v-pills-recycle-tab">
                {{ Form::open(array('method' => 'POST', 'url' => 'settings/update', 'id'=>'settings','class'=>'form-horizontal classFormUpdate')) }}
                <input type="hidden" name="id" value="{{ $option['id'] }}">
                <div class="form-group">
                  <label for="contacted_times">CS Contacted Times</label>
                  <input type="number" class="form-control" min="1" name="contacted_times" value="{{ $option['contacted_times'] }}">
                  <small class="form-text"><b>Note : </b> This value is the point how much contacted times for CS</small>
                </div>
                <div class="form-group">
                  <label for="assigned_times">Assigned Times</label>
                  <input type="number" class="form-control" min="1" name="assigned_times" value="{{ $option['assigned_times_now'] }}">
                  <small class="form-text"><b>Note : </b> This value is the point how much assign times for Leader</small>
                </div>
                <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Save</button>
                {{ Form::close() }}
              </div>

              <div class="tab-pane fade" id="v-pills-constant" role="tabpanel" aria-labelledby="v-pills-constant-tab">
                <div class="card">
                  <div class="card-header pt-1 pb-0">
                    <h3 class="card-title">Add Constant</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                    </div>
                  </div>
                  <div class="card-body p-1">
                    <form action="{{ url('settings/insert') }}" method="post">
                      @csrf
                      <div class="row mx-auto">
                        <div class="col-md-5">
                          <div class="form-group">
                            <label for="constant_name">Name</label>
                            <input type="text" class="form-control" id="constant_name" name="constant_name" placeholder="input name">
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <div class="col-md-5">
                          <!-- /.form-group -->
                          <div class="form-group">
                            <label for="constant_value">Value</label>
                            <input type="number" class="form-control" id="constant_value" name="constant_value" placeholder="input value">
                          </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-1">
                          <label for="" style="color: rgba(0, 0, 0, 0);">'</label>
                          <button type="submit" class="btn btn-md btn-primary" style="display : block;"><i class="fas fa-save"></i> Save</button>
                        </div>
                      </div>
                      <!-- /.row -->
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
                <div class="table-responsive users-table card">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Value</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($constant as $value)
                      <tr> 
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->value }}</td>
                        <td>
                          <button data-id="{{ $value->id }}" type="button" class="btn btn-sm btn-success editConstantBtn">Edit</button>
                          <a data-id="{{ $value->id }}" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-danger deleteConstantBtn" href="{{ url('constant-yesno/delete/') }}/{{ $value->id }}">Delete</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="v-pills-connect-response" role="tabpanel" aria-labelledby="v-pills-connect-response-tab">
                <div class="card">
                  <div class="card-header pt-1 pb-0">
                    <h3 class="card-title">Add Connect Response</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                    </div>
                  </div>
                  <div class="card-body p-1">
                    <form action="{{ url('connect-response/insert') }}" method="post">
                      @csrf
                      <div class="row mx-auto">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="connect_response_name">Name</label>
                            <input type="text" class="form-control" id="connect_response_name" name="connect_response_name" placeholder="input name">
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <div class="col-md-12">
                          <!-- /.form-group -->
                          <div class="form-group">
                            <label for="connect_response_description">Description</label>
                            <textarea placeholder="input description" class="form-control" name="connect_response_description" id="connect_response_description"></textarea>
                          </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-12 mb-1">
                          <button type="submit" class="btn btn-md btn-primary float-right"><i class="fas fa-save"></i> Save</button>
                        </div>
                      </div>
                      <!-- /.row -->
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
                <div class="table-responsive users-table card">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Value</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($connectResponse as $value)
                      <tr> 
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->description }}</td>
                        <td>
                          <button data-id="{{ $value->id }}" type="button" class="btn btn-sm btn-success editConnectResponseBtn">Edit</button>
                          <a data-id="{{ $value->id }}" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-danger deleteConstantBtn" href="{{ url('connect-response/delete/') }}/{{ $value->id }}">Delete</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="v-pills-campaign-result" role="tabpanel" aria-labelledby="v-pills-campaign-result-tab">
                <div class="card">
                  <div class="card-header pt-1 pb-0">
                    <h3 class="card-title">Add Campaign Result</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                    </div>
                  </div>
                  <div class="card-body p-1">
                    <form action="{{ url('campaign-result/insert') }}" method="post">
                      @csrf
                      <div class="row mx-auto">
                        <div class="col-md-10">
                          <div class="form-group">
                            <label for="campaign_result_name">Name</label>
                            <input type="text" class="form-control" id="campaign_result_name" name="campaign_result_name" placeholder="input name">
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-2 mb-1">
                          <label for="" style="color: rgba(0, 0, 0, 0);">'</label>
                          <button type="submit" class="btn btn-md btn-primary" style="display : block;"><i class="fas fa-save"></i> Save</button>
                        </div>
                      </div>
                      <!-- /.row -->
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
                <div class="table-responsive users-table card">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($campaignResult as $value)
                      <tr> 
                        <td>{{ $value->name }}</td>
                        <td>
                          <button data-id="{{ $value->id }}" type="button" class="btn btn-sm btn-success editCampaignResultBtn">Edit</button>
                          <a data-id="{{ $value->id }}" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-danger deleteConstantBtn" href="{{ url('campaign-result/delete/') }}/{{ $value->id }}">Delete</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="v-pills-next-action" role="tabpanel" aria-labelledby="v-pills-next-action-tab">
                <div class="card">
                  <div class="card-header pt-1 pb-0">
                    <h3 class="card-title">Add Next Action</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                    </div>
                  </div>
                  <div class="card-body p-1">
                    <form action="{{ url('next-action/insert') }}" method="post">
                      @csrf
                      <div class="row mx-auto">
                        <div class="col-md-10">
                          <div class="form-group">
                            <label for="next_action_name">Name</label>
                            <input type="text" class="form-control" id="next_action_name" name="next_action_name" placeholder="input name">
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-2 mb-1">
                          <label for="" style="color: rgba(0, 0, 0, 0);">'</label>
                          <button type="submit" class="btn btn-md btn-primary" style="display : block;"><i class="fas fa-save"></i> Save</button>
                        </div>
                      </div>
                      <!-- /.row -->
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
                <div class="table-responsive users-table card">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($nextAction as $value)
                      <tr> 
                        <td>{{ $value->name }}</td>
                        <td>
                          <button data-id="{{ $value->id }}" type="button" class="btn btn-sm btn-success editNextActionBtn">Edit</button>
                          <a data-id="{{ $value->id }}" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-danger" href="{{ url('next-action/delete/') }}/{{ $value->id }}">Delete</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="v-pills-category-web" role="tabpanel" aria-labelledby="v-pills-category-web-tab">
                <div class="card">
                  <div class="card-header pt-1 pb-0">
                    <h3 class="card-title">Add Web Category</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                    </div>
                  </div>
                  <div class="card-body p-1">
                    <form action="{{ url('category-web/insert') }}" method="post">
                      @csrf
                      <div class="row mx-auto">
                        <div class="col-md-10">
                          <div class="form-group">
                            <label for="category_web_name">Name</label>
                            <input type="text" class="form-control" id="category_web_name" name="category_web_name" placeholder="input name">
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-2 mb-1">
                          <label for="" style="color: rgba(0, 0, 0, 0);">'</label>
                          <button type="submit" class="btn btn-md btn-primary" style="display : block;"><i class="fas fa-save"></i> Save</button>
                        </div>
                      </div>
                      <!-- /.row -->
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
                <div class="table-responsive users-table card">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($categoryWeb as $value)
                      <tr> 
                        <td>{{ $value->name }}</td>
                        <td>
                          <button data-id="{{ $value->id }}" type="button" class="btn btn-sm btn-success editCategoryWebBtn">Edit</button>
                          <a data-id="{{ $value->id }}" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-danger" href="{{ url('category-web/delete/') }}/{{ $value->id }}">Delete</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="v-pills-category-game" role="tabpanel" aria-labelledby="v-pills-category-game-tab">
                <div class="card">
                  <div class="card-header pt-1 pb-0">
                    <h3 class="card-title">Add Game Category</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                    </div>
                  </div>
                  <div class="card-body p-1">
                    <form action="{{ url('category-game/insert') }}" method="post">
                      @csrf
                      <div class="row mx-auto">
                        <div class="col-md-10">
                          <div class="form-group">
                            <label for="category_game_name">Name</label>
                            <input type="text" class="form-control" id="category_game_name" name="category_game_name" placeholder="input name">
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-2 mb-1">
                          <label for="" style="color: rgba(0, 0, 0, 0);">'</label>
                          <button type="submit" class="btn btn-md btn-primary" style="display : block;"><i class="fas fa-save"></i> Save</button>
                        </div>
                      </div>
                      <!-- /.row -->
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
                <div class="table-responsive users-table card">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($categoryGame as $value)
                      <tr> 
                        <td>{{ $value->name }}</td>
                        <td>
                          <button data-id="{{ $value->id }}" type="button" class="btn btn-sm btn-success editCategoryGameBtn">Edit</button>
                          <a data-id="{{ $value->id }}" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-danger" href="{{ url('category-game/delete/') }}/{{ $value->id }}">Delete</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal edit constant --}}
  <div id="cosntantEditModal" class="modal fade bs-example-modal-sm\" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" style="max-width:500px !important;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            Edit Constant
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form action="{{ url('constant-yesno/update') }}" method="post" class="constant">
            @csrf
            <input type="hidden" name="id" id="constantId">
            <div class="form-group">
              <label for="constantValue">Value</label>
              <input type="number" min="0" id="constantValue" name="constantValue" class="form-control">
            </div>
            <div class="form-group">
              <label for="constantName">Name</label>
              <input type="text" min="0" id="constantName" name="constantName" class="form-control">
            </div>
            <button type="submit" class="btn btn-success float-right btn-save-constant">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal edit connect response --}}
  <div id="connectResponseEditModal" class="modal fade bs-example-modal-sm\" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" style="max-width:500px !important;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            Edit Connect Response
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form action="{{ url('connect-response/update') }}" method="post" class="connectResponse">
            @csrf
            <input type="hidden" name="id" id="connectResponseId">
            <div class="form-group">
              <label for="connectResponseName">Name</label>
              <input type="text" min="0" id="connectResponseName" name="connectResponseName" class="form-control">
            </div>
            <div class="form-group">
              <label for="connectResponseDescription">Description</label>
              <textarea placeholder="input description" class="form-control" name="connectResponseDescription" id="connectResponseDescription"></textarea>
            </div>
            <button type="submit" class="btn btn-success float-right btn-save-constant">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal edit campaign result --}}
  <div id="campaignResultEditModal" class="modal fade bs-example-modal-sm\" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" style="max-width:500px !important;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            Edit Connect Response
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form action="{{ url('campaign-result/update') }}" method="post" class="campaignResult">
            @csrf
            <input type="hidden" name="id" id="campaignResultId">
            <div class="form-group">
              <label for="campaignResultName">Name</label>
              <input type="text" min="0" id="campaignResultName" name="campaignResultName" class="form-control">
            </div>
            <button type="submit" class="btn btn-success float-right btn-save-constant">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal edit next action --}}
  <div id="nextActionEditModal" class="modal fade bs-example-modal-sm\" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" style="max-width:500px !important;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            Edit Next Action
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form action="{{ url('next-action/update') }}" method="post" class="nextAction">
            @csrf
            <input type="hidden" name="id" id="nextActionId">
            <div class="form-group">
              <label for="nextActionName">Name</label>
              <input type="text" min="0" id="nextActionName" name="nextActionName" class="form-control">
            </div>
            <button type="submit" class="btn btn-success float-right btn-save-constant">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal edit category web --}}
  <div id="categoryWebEditModal" class="modal fade bs-example-modal-sm\" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" style="max-width:500px !important;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            Edit Category WEB
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form action="{{ url('category-web/update') }}" method="post" class="categoryWeb">
            @csrf
            <div class="form-group">
              <label for="categoryWebName">Name</label>
              <input type="text" min="0" id="categoryWebName" name="categoryWebName" class="form-control">
            </div>
            <button type="submit" class="btn btn-success float-right">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

   {{-- Modal edit category game --}}
   <div id="categoryGameEditModal" class="modal fade bs-example-modal-sm\" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" style="max-width:500px !important;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            Edit Category Game
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form action="{{ url('category-game/update') }}" method="post" class="categoryGame">
            @csrf
            <div class="form-group">
              <label for="categoryGameName">Name</label>
              <input type="text" min="0" id="categoryGameName" name="categoryGameName" class="form-control">
            </div>
            <button type="submit" class="btn btn-success float-right">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('footer_scripts')
  {{-- @if (config('usersmanagement.enabledDatatablesJs'))
      @include('scripts.datatables')
  @endif --}}

  @include("scripts.$pageName")
  {{-- @if(config('usersmanagement.tooltipsEnabled'))
      @include('scripts.tooltips')
  @endif --}}
@endsection
