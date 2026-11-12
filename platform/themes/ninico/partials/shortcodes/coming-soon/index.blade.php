<section class="coming-soon-area tpcoming__bg" data-background="{{ RvMedia::getImageUrl($shortcode->background_image, default: RvMedia::getDefaultImage()) }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="tpcoming__area text-center">
                    @if($shortcode->logo_style)
                        <div class="tpcoming__logo">
                            <a href="{{ BaseHelper::getHomepageUrl() }}">
                                <img src="{{ RvMedia::getImageUrl($shortcode->logo_style) }}" alt="{{ theme_option('site_title') }}">
                            </a>
                        </div>
                    @endif
                    <div class="tpcoming__content">
                        @if($subtitle = $shortcode->subtitle)
                            <span>{!! BaseHelper::clean($subtitle) !!}</span>
                        @endif
                        @if($title = $shortcode->title)
                            <h4 class="tpcoming__title mb-50">{!! BaseHelper::clean($title) !!}</h4>
                        @endif
                    </div>
                    @if($shortcode->time)
                        <div class="tpcoming__count">
                            <div class="tpcoming__countdown" data-countdown="{{ $shortcode->time }}"></div>
                        </div>
                    @endif
                    @if(is_plugin_active('newsletter') && $shortcode->show_subscribe_form)
                        <div class="tpcoming__submit">
                            <form action="{{ route('public.newsletter.subscribe') }}" method="post" class="newsletter-form">
                                <input type="email" name="email" placeholder="{{ __('Email address') }}">
                                <span><i class="far fa-envelope"></i></span>
                                <button>{{ __('Subscribe Now') }} <i class="far fa-long-arrow-right"></i></button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
