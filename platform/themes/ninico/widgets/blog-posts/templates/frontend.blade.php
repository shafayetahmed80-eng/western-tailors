@if (is_plugin_active('blog') && $posts->isNotEmpty())
    <div class="sidebar__widget mb-55">
        <h3 class="sidebar__widget-title mb-25">{{ Arr::get($config, 'name') ?: __('Recent Post') }}</h3>
        <div class="sidebar__widget-content">
            <div class="sidebar__post rc__post">
                @foreach ($posts as $post)
                    <div @class(['rc__post d-flex align-items-center', 'mb-20' => ! $loop->last])>
                        <div class="rc__post-thumb">
                            <a href="{{ $post->url }}">
                                <img src="{{ RvMedia::getImageUrl($post->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $post->name }}">
                            </a>
                        </div>
                        <div class="rc__post-content">
                            <div class="rc__meta">
                                <span>{{ Theme::formatDate($post->created_at) }}</span>
                            </div>
                            <h3 class="rc__post-title">
                                <a href="{{ $post->url }}">{!! BaseHelper::clean($post->name) !!}</a>
                            </h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif


