@if (is_plugin_active('blog') && $categories->isNotEmpty())
    <div class="sidebar__widget mb-40">
        <h3 class="sidebar__widget-title mb-25">{{ Arr::get($config, 'name') ?: __('Categories') }}</h3>
        <div class="sidebar__widget-content">
            <ul>
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ $category->url }}">
                            {{ $category->name }}
                            <span>{{ $category->posts_count }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

