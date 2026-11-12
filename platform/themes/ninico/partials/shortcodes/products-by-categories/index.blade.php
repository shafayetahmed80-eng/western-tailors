<section class="selected-product-area pt-70 pb-50">
    <div class="container">
        <div class="row">
            @foreach($categories as $category)
                <div class="col-xxl-3 col-lg-6 col-md-6">
                    <div class="tpselectproduct">
                        <h4 class="tpselectproduct__heading mb-35">{{ $category->name }}</h4>
                        @foreach($category->products as $product)
                            <div class="tpselectproduct__item d-flex align-items-center mb-25">
                                <div class="tpselectproduct__thumb mr-25">
                                    <img src="{{ RvMedia::getImageUrl($product->image, 'small') }}" alt="{{ $product->name }}">
                                </div>
                                <div class="tpselectproduct__content">
                                    <div class="tpproduct-details__rating">
                                        <div class="product-rating-wrapper">
                                            <div class="product-rating" style="width: {{ $product->reviews_avg_star * 20 }}%"></div>
                                        </div>
                                    </div>
                                    <h4 class="tpselectproduct__title">
                                        <a href="{{ $product->url }}">{{ $product->name }}</a>
                                    </h4>
                                    <div class="tpselectproduct__price">
                                        @include(EcommerceHelper::viewPath('includes.product-price'), [
                                            'product' => $product,
                                            'priceOriginalClassName' => 'tpproduct__priceinfo-list-oldprice small',
                                        ])
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
