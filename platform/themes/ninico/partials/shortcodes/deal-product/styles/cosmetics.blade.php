<section class="dealproduct-area platinam-light pt-30 pb-30 p-relative fix" @if ($shortcode->background_color) style="background-color: {{ $shortcode->background_color }} !important;" @endif>
    @if($shortcode->marque_highlight_text)
        @php
            $image = RvMedia::getImageUrl($shortcode->highlight_background);
            $marqueText = str_replace($shortcode->marque_highlight_text, "<span style='background-image: url($image)'><a href='$shortcode->marque_highlight_url'>$shortcode->marque_highlight_text</a></span>", $shortcode->marque_text);
        @endphp

        <div class="container-fluid g-0">
            <div class="mp-marque-slider">
                <div class="swiper-container swiper--top">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <p>{!! BaseHelper::clean($marqueText) !!}</p>
                        </div>
                        <div class="swiper-slide">
                            <p>{!! BaseHelper::clean($marqueText) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="container">
        <div class="platinamdell pt-140">
            <div class="row">
                <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-12">
                    <div class="tpdealcontact tp-red-deal-text pt-30 mb-30">
                        <div class="tpdealcontact__price mb-5">
                            @include(EcommerceHelper::viewPath('includes.product-price'), ['product' => $product])
                        </div>
                        <div class="tpdealcontact__text mb-30">
                            <h4 class="tpdealcontact__title mb-10">
                                <a href="{{ $product->url }}">{{ $product->name }}</a>
                            </h4>
                            <p>{!! BaseHelper::clean($product->description) !!}</p>
                        </div>
                        <div class="tpdealcontact__progress mb-30">
                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $product->pivot->quantity > 0 ? ($product->pivot->sold / $product->pivot->quantity) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <div class="tpdealcontact__count">
                            <div class="tpdealcontact__countdown" data-countdown="{{ $flashSale->end_date }}"></div>
                            <i>{!! BaseHelper::clean(__('Remains until the <br> end of the offer') )!!}</i>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-7 col-xl-6 col-lg-6 col-md-12">
                    <div class="tpdealproduct mb-30">
                        <div class="tpdealproduct__thumb">
                            <img src="{{ RvMedia::getImageUrl($product->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
