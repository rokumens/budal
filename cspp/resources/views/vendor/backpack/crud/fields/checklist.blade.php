@php
    $roleId = Request::segment(2);
    $rolePermissionNext = DB::table('role_has_permissions')->where('role_id', '>', $roleId)->where('role_id', '<', 4)->get();
    // dd($rolePermissionNext);
@endphp

<!-- select2 -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    <?php $entity_model = $crud->getModel(); ?>
    
    @if(Request::segment(1) == 'role' && (Request::segment(2) == 1 || Request::segment(2) == 2 || Request::segment(2) == 3))
        <div class="row">
            @foreach ($field['model']::all() as $connected_entity_entry)
                <div class="col-sm-4">
                    <div class="checkbox">
                    <label class="font-weight-normal">
                        <input type="checkbox"
                        id="checkBox{{ $connected_entity_entry->getKey() }}"
                        class="checkboxRelease"
                        name="{{ $field['name'] }}[]"
                        value="{{ $connected_entity_entry->getKey() }}"

                        @if( ( old( $field["name"] ) && in_array($connected_entity_entry->getKey(), old( $field["name"])) ) || (isset($field['value']) && in_array($connected_entity_entry->getKey(), $field['value']->pluck($connected_entity_entry->getKeyName(), $connected_entity_entry->getKeyName())->toArray())))
                                checked = "checked"
                        @endif > {!! $connected_entity_entry->{$field['attribute']} !!}
                    </label>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row">
            @foreach ($field['model']::all() as $connected_entity_entry)
                <div class="col-sm-4">
                    <div class="checkbox">
                    <label class="font-weight-normal">
                        <input type="checkbox"
                        name="{{ $field['name'] }}[]"
                        value="{{ $connected_entity_entry->getKey() }}"

                        @if( ( old( $field["name"] ) && in_array($connected_entity_entry->getKey(), old( $field["name"])) ) || (isset($field['value']) && in_array($connected_entity_entry->getKey(), $field['value']->pluck($connected_entity_entry->getKeyName(), $connected_entity_entry->getKeyName())->toArray())))
                                checked = "checked"
                        @endif > {!! $connected_entity_entry->{$field['attribute']} !!}
                    </label>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

@push('crud_fields_scripts')
    @if(Request::segment(1) == 'role' && (Request::segment(2) == 1 || Request::segment(2) == 2 || Request::segment(2) == 3))
        <script>
            var json = {!! $rolePermissionNext !!}
            @foreach($rolePermissionNext as $v)
                {!! "$('#checkBox".$v->permission_id."').attr({checked:'checked', disabled:'disabled'})" !!}
            @endforeach

            $('button[type=submit]').click(function(e){
                $('.checkboxRelease').removeAttr('disabled');
            });
        </script>
    @endif
@endpush