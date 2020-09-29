<div class="pull-right">
    {!! Form::open(['route' => 'search-items', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'id' => 'search_users']) !!}
        {!! csrf_field() !!}
        @role('admin')
        <div class="custom-control custom-checkbox">
          <input name="contacted_chk" type="checkbox" class="custom-control-input" id="checkboxByContacted">
          <label class="custom-control-label" for="checkboxByContacted">By already contacted</label>
        </div>
        @endrole
        <div class="input-group mb-3">
            @role('admin')
            <div class="input-group-prepend">
              <span class="input-group-text">Date</span>
            </div>
            <input name="start_date_val" id="startDate" type="date" class="form-control" />
            <input name="end_date_val" id="endDate" type="date"class="form-control" />
            @endrole
            {!! Form::text('user_search_box', NULL, ['id' => 'user_search_box', 'class' => 'form-control', 'placeholder' => trans('Search...'), 'aria-label' => trans('Search'), 'required' => false]) !!}
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
                        {!!  trans('CLick to search') !!}
                    </span>
                </a>
            </div>
        </div>
    {!! Form::close() !!}
</div>
