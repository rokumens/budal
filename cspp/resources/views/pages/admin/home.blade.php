@extends('layouts.app')

@section('template_title')
    Welcome {{ backpack_user()->name }}
@endsection

@section('head')
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
<div class="container-fluid">

<!-- /.row -->
  <div class="row">
    <div class="col-md-12">
      <div class="card card-info card-outline">
        <div class="card-header">
          <h5 class="m-0">Welcome back, {{ backpack_user()->nik }} - {{ backpack_user()->name }}.</h5>
        </div>
        <div class="card-body">
          @if( backpack_user()->can('dashboard-all') )
          <p>You can see tutorial here if you are still confusing what to do.</p>
          <a href="/demoleader" target="__blank" class="btn btn-info">See tutorial &raquo;</a>
          @else
          <p>
              Please notify or ask your leader now to assign contacts data for you.
          </p>
          <p>You can see tutorial here if you are still confusing what to do.</p>
          <a href="/democs" class="btn btn-info" target="__blank">See tutorial &raquo;</a>
          @endif
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->

  <div class="row">

    <div class="col">
      <div class="card text-white bg-success mb-2">
        <div class="card-body">
          <div class="text-value">{{number_format($countNewnumbers)}}</div>
          <div>New Numbers</div>
          <small class="text-muted">
            <a href="{{ url('numbers/newnumbers') }}" class="small-box-footer" style="color: #000000 !important;">See numbers <i class="fa fa-arrow-circle-right"></i></a>
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
      <div class="card text-white bg-info mb-2">
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
      <div class="card text-white bg-primary mb-2">
        <div class="card-body">
          <div class="text-value">{{number_format($countPlayers)}}</div>
          <div>Lovely Players</div>
          <small class="text-muted">
            <a href="{{ url('numbers/players') }}" class="small-box-footer" style="color: #000000 !important;">See numbers <i class="fa fa-arrow-circle-right"></i></a>
          </small>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card text-white bg-danger mb-2">
        <div class="card-body">
          <div class="text-value">{{number_format($countTrash)}}</div>
          <div>Trash</div>
          <small class="text-muted">
            <a href="{{ url('numbers/trash') }}" class="small-box-footer" style="color: #000000 !important;">See numbers <i class="fa fa-arrow-circle-right"></i></a>
          </small>
        </div>
      </div>
    </div>
    
  </div>
  <!-- /.row -->
</div>

@endsection