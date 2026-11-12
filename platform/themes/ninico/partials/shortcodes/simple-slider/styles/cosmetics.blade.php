<section class="slider-area platinam-light">
    <div class="container">
        <div class="platinamborder p-relative">
            <div class="swiper-container sliderthree-active">
                <div class="swiper-wrapper">
                    @foreach($sliders as $slider)
                        <div class="swiper-slide platinam-light slider-bg-four" @if ($shortcode->background_color) style="background-color: {{ $shortcode->background_color }} !important;" @endif>
                            <div class="row align-items-center">
                                <div class="col-xl-6 col-lg-6 col-md-12">
                                    <div class="tpslidertwo__item slidre-item-4 ml-145 text-center">
                                        <div class="tpslidertwo__content">
                                            @if($slider->title)
                                                <h3 class="tpslidertwo__title mb-10">
                                                    {!! BaseHelper::clean($slider->title) !!}
                                                </h3>
                                            @endif
                                            @if($description = $slider->description)
                                                <div>{!! BaseHelper::clean($description) !!}</div>
                                            @endif
                                            @if(($actionLabel = $slider->getMetaData('action_label', true)) && $slider->link)
                                                <div class="tpslidertwo__slide-btn d-flex justify-content-center">
                                                    <a class="tp-btn banner-animation tpslider-btn-4 mr-25" href="{{ $slider->link }}">
                                                        {{ $actionLabel }}
                                                        <i class="fal fa-long-arrow-right"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div @class(['col-xl-6 col-lg-6', 'd-none d-lg-block' => ! $shortcode->show_slider_image_on_mobile])>
                                    <div class="tpslidertwo__img p-relative pt-80 pb-80">
                                        @include(Theme::getThemeNamespace('partials.shortcodes.simple-slider.includes.image'))
                                    </div>
                                </div>
                                <div class="tpsliderthree__pagination"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
