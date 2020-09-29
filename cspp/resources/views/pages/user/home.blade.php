@extends('layouts.app')

@section('template_title')
    {{ backpack_user()->name }}'s' Homepage
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
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="card-body">
  @include('panels.welcome-panel')
</div>

<div class="content">
  <div class="container-fluid">
    <div class="row">

      <div class="col">
        <div class="card text-white bg-danger mb-2">
          <div class="card-body">
            <div class="text-value">{{number_format($countAssigned)}}</div>
            <div>Assigned</div>
            <small class="text-muted">
              <a href="{{ url('numbers/assigned') }}" class="small-box-footer" style="color: #000000 !important;">See numbers <i class="fa fa-arrow-circle-right"></i></a>
            </small>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card text-white bg-warning mb-2">
          <div class="card-body">
            <div class="text-value">{{number_format($countContacted)}}</div>
            <div>Contacted</div>
            <small class="text-muted">
              <a href="{{ url('numbers/contacted') }}" class="small-box-footer" style="color: #000000 !important;">See numbers <i class="fa fa-arrow-circle-right"></i></a>
            </small>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card text-white bg-primary mb-2">
          <div class="card-body">
            <div class="text-value">{{number_format($countInterested)}}</div>
            <div>Interested</div>
            <small class="text-muted">
              <a href="{{ url('numbers/followup/interested') }}" class="small-box-footer" style="color: #000000 !important;">See numbers <i class="fa fa-arrow-circle-right"></i></a>
            </small>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card text-white bg-success mb-2">
          <div class="card-body">
            <div class="text-value">{{number_format($countRegistered)}}</div>
            <div>Registered</div>
            <small class="text-muted">
              <a href="{{ url('numbers/followup/registered') }}" class="small-box-footer" style="color: #000000 !important;">See numbers <i class="fa fa-arrow-circle-right"></i></a>
            </small>
          </div>
        </div>
      </div>

    </div>
    <!-- /.row -->
  </div>
</div>

@endsection
