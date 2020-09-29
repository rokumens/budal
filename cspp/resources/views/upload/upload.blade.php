@extends('layouts.app')

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
    @include('partials.flashdata')
  </div>
  <div class="content">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title">Upload New Number</h2>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-10">

            <form action="{{url('numbers/upload/import')}}" method="post" enctype="multipart/form-data" class="pull-left">
                {{csrf_field()}}
                <div class="input-group">
                  <div class="input-group-prepend">
                      <input class="input-group-text invisible" name="category_web" id="catWebExcelValue" style="width:1px;" readonly />
                      <input class="input-group-text  invisible" name="category_game" id="catExcelValue" style="width:1px;" readonly />
                  </div>
                  <div class="custom-file">
                    <input type="file" name="imported-file" class="custom-file-input" accept=".xls,.xlsx" id="uploadExcel" aria-describedby="submitExcel" style="width:600px !important;">
                    <label class="custom-file-label" for="uploadExcel">Choose file</label>
                  </div>
                  {{-- Category Web --}}
                  <div class="input-group-prepend" data-toggle="tooltip" title="Category Web">
                    <button id="btnGroupCatWeb" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      Web
                    </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupCatWeb" id="listCatWeb">
                          @if ($catWeb)
                            @foreach($catWeb as $singWeb)
                              <a href="javascript:;" class="dropdown-item" data-value="{{ $singWeb->id }}">{{ $singWeb->name }}</a>
                            @endforeach
                          @endif
                        </div>
                  </div>
                  {{-- Category Game --}}
                  <div class="input-group-prepend" title="Category Game" data-toggle="tooltip" title="Category Game" style="display:none;" id="divCatGame">
                    <button id="btnGroupCatGame" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      Game
                    </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupCatGame" id="listCatGame">
                          @if ($catGames)
                            @foreach($catGames as $singGame)
                              <a href="javascript:;" class="dropdown-item" data-value="{{ $singGame->id }}">{{ $singGame->name }}</a>
                            @endforeach
                          @endif
                        </div>
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-outline-primary" id="submitExcel"><i class="fa fa-upload"></i> Upload</button>
                  </div>
                </div>
            </form>

          </div>
          <div class="col-md-2">
            <div class="input-group-append float-right">
              <a class="btn btn-outline-info btn-md" href="{{ url('/file-download') }}"><i class="fa fa-download"></i> &nbsp;Example</a>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
@endsection

@section('footer_scripts')
  @if (config('usersmanagement.enabledDatatablesJs'))
    @include('scripts.datatables')
  @endif

  @include('scripts.items-action-all-script')
  @if(config('usersmanagement.tooltipsEnabled'))
    @include('scripts.tooltips')
  @endif
<script>
$(document).ready(function () {

  // pastikan pilih category web & game sebelum upload.
  $('#submitExcel').on('click', function(){
    if ( $("#catWebExcelValue").val()==='' ) {
        $('#btnGroupCatWeb').addClass("tombolKedip-outline");
        alert( "Please chooose Web Category." );
        return false;
    }
    if ( $("#catExcelValue").val()==='' ) {
        $('#btnGroupCatGame').addClass("tombolKedip-outline");
        alert( "Please chooose Game Category." );
        return false;
    }
  });

  $('.custom-file-input').on('change',function(){
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName);
  })
});
</script>
@endsection