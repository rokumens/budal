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
    .detail-date{
      display: block;
    }
    table.detail-player > tbody > tr > th > small{
      margin-right : 10px;
    }
    table.detail-player > tbody > tr > td > small{
      margin-left : 10px;
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
        <h2 class="card-title">Deleted Users</h2>
      </div>
      <div class="card-body">
        <div class="users-table">
          <table id="clients_ajax_table_server_side" class="table table-striped table-bordered" style="width:100%;">
            <thead>
              <tr>
                <th>NIK</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="numbers_table"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('after_scripts')
@endsection

@section('footer_scripts')
    <script>
      $('.restore').click(function(){
        alert('wdwddw');
      });
    </script>
    @include("scripts.user.$pageName")
@endsection
