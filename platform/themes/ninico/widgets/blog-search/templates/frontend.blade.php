@if (is_plugin_active('blog'))
    <div class="sidebar__widget mb-45">
        <div class="sidebar__widget-content">
            <h3 class="sidebar__widget-title mb-25">{{ Arr::get($config, 'name') ?: __('Search') }}</h3>
            <div class="sidebar__search">
                <form action="{{ route('public.search') }}">
                    <div class="sidebar__search-input-2 p-relative">
                        <input type="text" name="q" placeholder="{{ __('Enter keyword...') }}" value="{{ BaseHelper::stringify(request()->query('q')) }}">
                        <button type="submit"><i class="far fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
