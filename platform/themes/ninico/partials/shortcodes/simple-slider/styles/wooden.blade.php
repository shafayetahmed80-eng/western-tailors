<div class="container">
    <div class="row justify-content-xl-end">
        <div @class(['col-xl-9 col-xxl-7 col-lg-9' => $hasAds, 'col-xl-12 col-xxl-10 col-lg-12' => ! $hasAds])>
            <div class="tp-slider-area p-relative">
                <div class="swiper-container slider-active">
                    <div class="swiper-wrapper">
                        @foreach($sliders as $slider)
                            <div class="swiper-slide">
                                <div class="tp-slide-item">
                                    <div class="tp-slide-item__content">
                                        @if($slider->description)
                                            <h4 class="tp-slide-item__sub-title">{!! BaseHelper::clean($slider->description) !!}</h4>
                                        @endif
                                        @if($slider->title)
                                            <h3 class="tp-slide-item__title mb-25">{!! BaseHelper::clean($slider->title) !!}</h3>
                                        @endif
                                        @if(($actionLabel = $slider->getMetaData('action_label', true)) && $slider->link)
                                            <a class="tp-slide-item__slide-btn tp-btn" href="{{ $slider->link }}">
                                                {{ $actionLabel }} <i class="fal fa-long-arrow-right"></i>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="tp-slide-item__img">
                                        @include(Theme::getThemeNamespace('partials.shortcodes.simple-slider.includes.image', compact('slider')))
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="slider-pagination"></div>
            </div>
        </div>
        @if(is_plugin_active('ads') && $hasAds)
            <div class="col-xl-3 col-xxl-3 col-lg-3">
                <div class="row">
                    @foreach(range(1, 2) as $i)
                        @continue(! $shortcode->{'ads_' . $i})

                        @if($ads = AdsManager::getAds($shortcode->{'ads_' . $i}))
                            <div class="col-lg-12 col-md-6">
                                <div @class(['tpslider-banner', 'tp-slider-sm-banner mt-4 mt-sm-0' => $loop->first])>
                                    <a href="{{ $ads->url }}">
                                        <div class="tpslider-banner__img">
                                            <img src="{{ RvMedia::getImageUrl($ads->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $ads->name }}">
                                            @if($shortcode->show_ads_title !== '0')
                                                <div class="tpslider-banner__content">
                                                    <h4 class="tpslider-banner__title">{!! BaseHelper::clean($ads->name) !!}</h4>
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
