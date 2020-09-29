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
@endsection

@php
  $defaultBreadcrumbs = [
    trans(Request::segment(1)) => url(config('backpack.base.route_prefix'), 'dashboard'),
    // $crud->entity_name_plural => url($crud->route),
    trans(Request::segment(2)) => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('content')
    
  <div class="content-header">
    {{-- Flashdata --}}
    @include('partials.flashdata')
  </div>

  <div class="content">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title">New Numbers</h2>
      </div>
      <div class="card-body">
        <div class="row">
          @can('assign-cs')
          <div class="col-md-4">
            <select class="custom-select form-control assignto" name="role" id="role" data-style="btn-default btn-lg">
                <option value="">Assign to</option>
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
                @can('assign-cs')
                <th data-orderable="false">
                  <div class="custom-control custom-checkbox text-center" style="left: 5px;">
                    <input type="checkbox" class="custom-control-input" id="check_all" />
                    <label class="custom-control-label" for="check_all"></label>
                  </div>
                </th>
                @endcan
                <th>Number</th>
                <th>Web Category</th>
                <th>Game Category</th>
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
<div id="viewModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" data-backdrop="false">
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
          <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded box-shadow">
            <div class="lh-100">
              <h6 id="phone" class="mb-0 text-white lh-100">loading data...</h6>
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
            <div class="media text-muted pt-3">
              <img data-src="holder.js/32x32?theme=thumb&bg=e83e8c&fg=e83e8c&size=1" alt="" class="mr-2 rounded">
              <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark">upload date</strong>
                <span id="uploaded_at">loading data...</span>
              </p>
            </div>
          </div>

        </main>

      </div>
    </div>
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
