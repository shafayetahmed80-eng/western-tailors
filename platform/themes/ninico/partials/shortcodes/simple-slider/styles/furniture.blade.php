<section class="slider-area">
    <div class="secondary-slider p-relative">
        <div class="swiper-container greenslider-active">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                    <div class="swiper-slide slider-bg-2 slider-3" @if ($shortcode->background_color) style="background-color: {{ $shortcode->background_color }} !important;" @endif>
                        <div class="container">
                            <div class="row p-relative justify-content-xl-end align-items-center">
                                <div class="col-xl-5 col-lg-6 col-md-6">
                                    <div class="tpslidertwo__content slider-content-3">
                                        @if($slider->title)
                                            <h3 class="tpslidertwo__title mb-10">
                                                {!! BaseHelper::clean($slider->title) !!}
                                            </h3>
                                        @endif
                                        @if($slider->description)
                                            <div class="mb-20">{!! BaseHelper::clean($slider->description) !!}</div>
                                        @endif
                                        @if(($actionLabel = $slider->getMetaData('action_label', true)) && $slider->link)
                                            <div class="tpslidertwo__slide-btn d-flex align-items-center">
                                                <a class="tp-btn banner-animation mr-25" href="{{ $slider->link }}">
                                                    {{ $actionLabel }}
                                                    <i class="fal fa-long-arrow-right"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div @class(['col-xl56 col-lg-6 col-md-6', 'd-none d-md-block' => ! $shortcode->show_slider_image_on_mobile])>
                                    <div class="tpsliderthree__img p-relative text-end pt-55">
                                        @include(Theme::getThemeNamespace('partials.shortcodes.simple-slider.includes.image'))
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="greenslider-pagination"></div>
    </div>
</section>
