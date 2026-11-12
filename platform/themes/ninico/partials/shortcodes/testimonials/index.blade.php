<section class="testimonial-area pt-50 pb-50" @style(["background-color: $shortcode->background_color" => $shortcode->background_color])>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                @if($title = $shortcode->title)
                    <div class="tpsection mb-35">
                        <h2 class="tpsection__title">{!! BaseHelper::clean($title) !!}</h2>
                    </div>
                @endif
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="tptestiarrow tp-white-testimonial d-flex align-items-center justify-content-end">
                    <div class="tptestiarrow__prv"><i class="far fa-long-arrow-left"></i>{{ __('Prev') }}</div>
                    <div class="tptestiarrow__nxt">{{ __('Next') }}<i class="far fa-long-arrow-right"></i></div>
                </div>
            </div>
        </div>
        <div class="swiper-container testi-active">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                    <div class="swiper-slide">
                        <div class="tptesti text-center" @style(["background-color: $shortcode->card_color" => $shortcode->card_color])>
                            <div class="tptesti__icon mb-25">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="16" viewBox="0 0 22 16">
                                    <image id="testi-icon-01.svg" width="22" height="16" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAQCAYAAAAS7Y8mAAABcElEQVQ4jbXUPWtVQRDG8V9uJr4mSBRM4RvYJEEMiqLYhWAjCFamEVut/A52IZAyjYXmA4igRcBYCIqNFoKFkhSCVUBQQVAQTbyyYS9clj2HiDiwnGXmmf/szu6egYhQ2F5cx1VMYA8uYLUU9tkUbmIaY3hQUlPgHg5gGffxCesNwB2Yxy28xaP8XZNWnMe1iOhGxFJEjPX5m8ZQRKxExLeImC01vcnJDJ3bBrA3FiPia0SM1+K9Hj/HT1xs6WO/ncNLXMLjmiCBJ/EOZ/B6m+DUy0M42yTo4DI+/AV0Zz7kO22i1IdTucDttIMi/hvfsYTP2bcfwxl+uML8gTeRoUk4U4C7GMmFn/SBO7ngCRyp5JzG08gP4AWuVKofx/ucUO70Bl5Vcu7iYCcnDTa0aleDvy2WinY7LYn/ZP8dnA6jZr9acjca/Fus3q3Yh6MV0bEWcLpqtZzRrYeX/1zn8axhR1+KlW/iIxbyvLTdePgHAXhADHlkJs8AAAAASUVORK5CYII="/>
                                </svg>
                            </div>
                            <div class="tptesti__content pb-5">
                                <div>{!! BaseHelper::clean($testimonial->content) !!}</div>
                            </div>
                            <div class="tptesti__avata d-flex align-items-center justify-content-center">
                                <div class="tptesti__avata-icon mr-20">
                                    <img src="{{ RvMedia::getImageUrl($testimonial->image) }}" alt="{{ $testimonial->name }}">
                                </div>
                                <div class="tptesti__avata-content text-start">
                                    <h5 class="tptesti__avata-content-title">{{ $testimonial->name }}</h5>
                                    <p>{{ $testimonial->company }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
