@php(Theme::set('pageTitle', ''))

<div class="postbox-area">
    <div class="container">
        <div class="row">
            <div class="col-xxl-8 col-xl-8 col-lg-7 col-md-12">
                <div class="postbox__wrapper pr-20">
                    <article class="postbox__item format-image mb-50 transition-3">
                        <div class="postbox__thumb w-img mb-30">
                            <img src="{{ RvMedia::getImageUrl($post->image, default: RvMedia::getDefaultImage()) }}" alt="{{ $post->name }}">
                        </div>
                        <div class="postbox__content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="postbox__content postbox__content-area mb-55">
                                        <div class="postbox__meta mb-15">
                                            <span><i class="fal fa-user-alt"></i> {{ $post->author->name }}</span>
                                            <span><i class="fal fa-clock"></i> {{ Theme::formatDate($post->created_at) }}</span>
                                            <span><i class="fal fa-eye"></i> {{ number_format($post->views) }}</span>
                                        </div>
                                        <h4 class="mb-35">
                                            {{ $post->name }}
                                        </h4>
                                        <div>
                                            <div class="ck-content">{!! BaseHelper::clean($post->content) !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="postbox__tag-border">
                                <div class="row align-items-center">
                                    <div class="col-xl-7 col-md-12">
                                        @if ($post->tags->isNotEmpty())
                                            <div class="postbox__tag">
                                                <div class="postbox__tag-list tagcloud">
                                                    <span>{{ __('Tags') }}</span>
                                                    @foreach ($post->tags as $tag)
                                                        <a href="{{ $tag->url }}">{{ $tag->name }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-xl-5 col-md-12">
                                        <div class="postbox__social-tag">
                                            <span>{{ __('Share') }}</span>

                                            {!! Theme::renderSocialSharing($post->url, SeoHelper::getDescription(), $post->image) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    @if (theme_option('facebook_comment_enabled_in_post') === 'yes')
                        <div class="postbox__comment mb-65">
                            <h3 class="postbox__comment-title">{{ __('Comment') }}</h3>
                            {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, null, $post) !!}
                        </div>
                    @endif

                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-12">
                <div class="sidebar__wrapper pl-25 pb-50">
                    {!! dynamic_sidebar('blog_sidebar') !!}
                </div>
            </div>
        </div>
    </div>
</div>
