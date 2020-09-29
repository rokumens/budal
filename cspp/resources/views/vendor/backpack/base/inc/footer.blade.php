@if (config('backpack.base.show_powered_by') || config('backpack.base.developer_link'))
    <div class="text-muted ml-auto mr-auto">
      @if (config('backpack.base.developer_link') && config('backpack.base.developer_name'))
      ❤️ {{ trans('backpack::base.handcrafted_by') }} <a href="#">{{ config('backpack.base.developer_name') }}</a>. {{ isset($title) ? config('backpack.base.project_name') : config('backpack.base.project_name') }}.
      @endif
    </div>
@endif