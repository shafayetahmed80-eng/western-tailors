<section class="dealproduct-area pt-30 pb-30">
    <div class="container">
        @php
            $priceForDisplay = $product->front_sale_price_with_taxes;
            $shouldShowPrice = (! EcommerceHelper::hideProductPrice() || EcommerceHelper::isCartEnabled()) && (! EcommerceHelper::hideProductPriceWhenZero() || $priceForDisplay > 0);
        @endphp
        <div class="theme-bg pt-40 pb-40" @if ($shortcode->background_color) style="background-color: {{ $shortcode->background_color }} !important;" @endif>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="tpdealproduct">
                        <div class="tpdealproduct__thumb p-relative text-center">
                            <img src="{{ RvMedia::getImageUrl($product->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
                            @if ($shouldShowPrice)
                                <div class="tpdealproductd__offer">
                                    <p class="tpdealproduct__offer-price">
                                        <span>{{ __('From') }}</span>{{ format_price($priceForDisplay) }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="tpdealcontact pt-30">
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
                            <i>{!! BaseHelper::clean(__('Remains until the <br> end of the offer')) !!}</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
