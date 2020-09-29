<div class="col-md-4"></div>
<div class="col-md-4">
  
  {{-- search --}}
    {!! Form::open(['route' => 'search-'.$pageName, 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation searchBox', 'id' => 'search_numbers']) !!}
      {!! csrf_field() !!}
      <div class="input-group mb-3">
        {!! Form::text('numbers_search_box', NULL, ['id' => 'numbers_search_box', 'class' => 'form-control', 'placeholder' => trans("Search phone number on $pageName..."), 'aria-label' => trans("Search"), 'required' => false]) !!}
        <input type="hidden" name="type" value="text">
        <div class="input-group-append">
          <a href="#" class="input-group-addon btn btn-warning clear-search" data-toggle="tooltip" title="{{ trans('usersmanagement.tooltips.clear-search') }}" style="display:none;">
            <i class="fa fa-fw fa-times" aria-hidden="true"></i>
            <span class="sr-only">
              {!! trans('usersmanagement.tooltips.clear-search') !!}
            </span>
          </a>
          <a href="#" class="input-group-addon btn btn-secondary" id="search_trigger" data-toggle="tooltip" data-placement="bottom" title="{{ trans('CLick to search') }}" >
            <i class="fa fa-search fa-fw" aria-hidden="true"></i>
            <span class="sr-only">
              {!!  trans('Click to search') !!}
            </span>
          </a>
        </div>
      </div>
    {!! Form::close() !!}

  {{-- date filter --}}
  <div class="input-daterange input-group datePickerContacted mb-3" id="datepicker" style="display:none;">
    <input type="text" class="form-control" name="contactedStartDate" id="startDate" value="{{-- Carbon::now()->format('j-F-Y') --}}" placeholder="From date..." readonly />
    <input type="text" class="form-control" name="contactedEndDate" id="endDate" value="{{-- Carbon::now()->format('j-F-Y') --}}" placeholder="To date..." readonly />
    <div class="input-group-append" id="inputDateGroup">
      <button class="btn btn-outline-secondary" type="button" id="contactedDateSearch">Filter contacted</button>
    </div>
  </div>

</div>
