<div class="postbox-area">
    <div class="row">
        <div class="col-xxl-8 col-xl-8 col-lg-7 col-md-12">
            <div class="row justi postbox pb-50">
                @foreach($posts as $post)
                    <div class="col-md-6">
                        <article class="postbox__item format-image mb-60 transition-3">
                            <div class="postbox__thumb w-img mb-25">
                                <a href="{{ $post->url }}">
                                    <img src="{{ RvMedia::getImageUrl($post->image, default: RvMedia::getDefaultImage()) }}" alt="{{ $post->name }}">
                                </a>
                            </div>
                            <div class="postbox__content">
                                <div class="postbox__meta mb-15">
                                    <span><i class="fal fa-user-alt"></i> {{ $post->author->name }}</span>
                                    <div class="d-flex gap-4">
                                        <span><i class="fal fa-clock"></i> {{ Theme::formatDate($post->created_at) }}</span>
                                        <span><i class="fal fa-eye"></i> {{ number_format($post->views) }}</span>
                                    </div>
                                </div>
                                <h3 class="postbox__title mb-20 text-truncate">
                                    <a href="{{ $post->url }}" title="{{ $post->name }}">{{ $post->name }}</a>
                                </h3>
                                <div class="postbox__text mb-30">
                                    <p>{{ Str::limit($post->description, 120) }}</p>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
                {{ $posts->links(Theme::getThemeNamespace('partials.pagination')) }}
            </div>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-12">
            <div class="sidebar__wrapper pl-25 pb-50">
                {!! dynamic_sidebar('blog_sidebar') !!}
            </div>
        </div>
    </div>
</div>
