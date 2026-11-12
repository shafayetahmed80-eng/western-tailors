@extends(Theme::getThemeNamespace('partials.shortcodes.featured-posts.layout'))

@section('content')
    <div class="row">
        @foreach($posts as $post)
            <div class="col-lg-3 col-md-4 col-sm-4">
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
                                @if ($category = $post->firstCategory)
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
        @endforeach
    </div>
@stop
