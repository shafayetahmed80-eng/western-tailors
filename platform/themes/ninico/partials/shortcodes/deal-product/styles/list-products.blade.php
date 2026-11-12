<section class="flash-sale dealproduct-area pt-30 pb-30">
    <div class="container">
        <div class="theme-bg pt-40 pl-40 pr-40" @if ($shortcode->background_color) style="background-color: {{ $shortcode->background_color }} !important;" @endif>
            <div class="row mb-40">
                <div class="col-md-6 col-12">
                    <div class="tpsection mb-40">
                        <h2 class="tpsection__title">{!! BaseHelper::clean($shortcode->title ?: $flashSale->name) !!}</h2>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="text-start text-sm-end">
                        <p class="small text-muted mb-1">{!! BaseHelper::clean(__('Remains until the end of the offer')) !!}</p>
                        <div class="tpdealcontact__countdown" data-countdown="{{ $flashSale->end_date }}"></div>
                    </div>
                </div>
            </div>

            <div class="flash-sale-slider swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($flashSale->products as $product)
                        <div class="swiper-slide">
                            @include(Theme::getThemeNamespace('views.ecommerce.includes.product-item'))
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
