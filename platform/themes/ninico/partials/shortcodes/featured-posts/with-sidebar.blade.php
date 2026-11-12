@extends(Theme::getThemeNamespace('partials.shortcodes.featured-posts.layout'))

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                @foreach($posts as $post)
                    @if ($loop->index < 2)
                        <div class="col-lg-6">
                            <div class="blogitem mb-40">
                                <div class="blogitem__thumb fix mb-20">
                                    <a href="{{ $post->url }}">
                                        {{ RvMedia::image($post->image, $post->name, 'medium') }}
                                    </a>
                                </div>
                                <div class="blogitem__content">
                                    <div class="blogitem__contetn-date mb-10">
                                        <ul>
                                            <li>
                                                <a class="date-color">{{ Theme::formatDate($post->created_at) }}</a>
                                            </li>
                                            @if($category = $post->firstCategory)
                                                <li>
                                                    <a href="{{ $category->url }}">{{ $category->name }}</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <h4 class="blogitem__title">
                                        <a href="{{ $post->url }}">{{ $post->name }}</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sidebar__post rc__post">
                @foreach ($posts->skip(2) as $post)
                    <div @class(['rc__post d-flex align-items-center', 'mb-20' => ! $loop->last])>
                        <div class="rc__post-thumb">
                            <a href="{{ $post->url }}">
                                {{ RvMedia::image($post->image, $post->name, 'medium') }}
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
@stop
