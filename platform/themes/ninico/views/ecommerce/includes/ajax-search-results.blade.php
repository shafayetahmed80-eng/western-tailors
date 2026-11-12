@if ($products->isNotEmpty())
    <div class="panel__content">
        <div class="p-3">
            @foreach($products as $product)
                <div class="product-item row mb-3" {!! EcommerceHelper::jsAttributes('product-item', $product) !!}>
                    <div class="col-3 col-xl-2">
                        <a href="{{ $product->url }}" data-bb-toggle="product-link">
                            <img src="{{ RvMedia::getImageUrl($product->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}" class="w-100 rounded">
                        </a>
                    </div>
                    <div class="col-9 col-xl-10">
                        <div class="text-start px-1">
                            <div>
                                <a href="{{ $product->url }}" class="product-name" data-bb-toggle="product-link">{!! BaseHelper::clean($product->name) !!}</a>
                            </div>
                            @if (EcommerceHelper::isReviewEnabled() && $product->reviews_count)
                                <div class="product-rating">
                                    <div class="product-rating-wrapper">
                                        <div class="product-rating" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                                    </div>
                                    <a href="{{ $product->url }}#reviews">({{ number_format($product->reviews_count) }})</a>
                                </div>
                            @endif
                            <div class="product-price">
                                @include(EcommerceHelper::viewPath('includes.product-price'), [
                                    'product' => $product,
                                    'priceOriginalClassName' => 'oldprice',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($products->hasMorePages() && $products->nextPageUrl())
            <div class="text-center loadmore-container">
                <a class="loadmore fw-bold fs-6 pt-1 pb-3" href="{{ $products->withQueryString()->nextPageUrl() }}">
                    {{ __('Load more') }}
                </a>
            </div>
        @endif
    </div>
    <div class="panel__footer text-center">
        <a href="{{ route('public.products', $queries) }}" class="fw-bold fs-6 text-primary">{{ __('See all results') }}</a>
    </div>
@else
    <div class="panel__content">
        <div class="text-center py-3 fs-6 text-secondary">{{ __('No products found.') }}</div>
    </div>
@endif
