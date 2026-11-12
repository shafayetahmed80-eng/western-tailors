@if (is_plugin_active('blog') && $tags->isNotEmpty())
    <div class="sidebar__widget mb-55">
        <h3 class="sidebar__widget-title mb-25">{{ Arr::get($config, 'name') ?: __('Tags') }}</h3>
        <div class="sidebar__widget-content">
            <div class="tagcloud">
                @foreach ($tags as $tag)
                    <a href="{{ $tag->url }}">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
@endif




