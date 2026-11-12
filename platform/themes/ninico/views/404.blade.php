@php
    SeoHelper::setTitle(__('404 - Not found'));
    Theme::fireEventGlobalAssets();
@endphp

@extends(Theme::getThemeNamespace('layouts.base'))

@section('content')
    {!! Theme::partial('headers.default') !!}

    <main>
        <section class="erroe-area pt-70 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="eperror__wrapper text-center">
                            <div class="tperror__thumb mb-35">
                                <img src="{{ RvMedia::getImageUrl(theme_option('404_not_found_icon'), default: RvMedia::getDefaultImage()) }}" alt="{{ theme_option('site_title') }}">
                            </div>
                            <div class="tperror__content">
                                <h4 class="tperror__title mb-25">{{ __('404. Page not found') }}</h4>
                                <p>{!! __('Sorry, we couldn’t find the page you where looking for. We suggest that <br> you return to homepage.') !!}</p>
                                <a href="{{ BaseHelper::getHomepageUrl() }}" class="tpsecondary-btn tp-color-btn tp-error-btn">
                                    <i class="fal fa-long-arrow-left"></i> {{ __('Back To Home') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {!! Theme::partial('footer') !!}
@stop
