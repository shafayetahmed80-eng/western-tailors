<div class="tp-slider-area p-relative">
    <div class="swiper-container slider-active">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
                <div class="swiper-slide">
                    <div class="tp-slide-item">
                        @if ($shortcode->show_slider_text)
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
                        @endif

                        <div class="tp-slide-item__img">
                            @include(Theme::getThemeNamespace('partials.shortcodes.simple-slider.includes.image'))
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="slider-pagination"></div>
</div>

