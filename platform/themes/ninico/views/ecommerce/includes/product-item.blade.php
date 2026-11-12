<div class="tpproduct pb-15 mb-30 product-item"
    data-product-id="{{ $product->id }}"
    data-product-name="{{ $product->name }}"
    data-product-price="{{ $product->price }}"
    data-product-sku="{{ $product->sku }}"
    @if($product->brand)
    data-product-brand="{{ $product->brand->name }}"
    @endif
    @if($product->categories->isNotEmpty())
    data-product-categories="{{ $product->categories->pluck('name')->implode(',') }}"
    @endif
>
    <div class="tpproduct__thumb p-relative">
        <div class="product__badge-list">
            @if ($product->isOutOfStock())
                <span class="tpproduct__thumb-topsall" style="background-color: #ff0000">
                    <span class="product__badge-item">{{ __('Out of stock') }}</span>
                </span>
            @else
                @if ($product->isOnSale() && $product->sale_percent)
                    <span class="tpproduct__thumb-topsall" style="background-color: #328f0a">
                        <span class="product__badge-item">{{ __(':percent% off', ['percent' => $product->sale_percent]) }}</span>
                    </span>
                @endif
                @if ($product->productLabels->isNotEmpty())
                    @foreach ($product->productLabels as $label)
                        <span class="tpproduct__thumb-topsall" {!! $label->css_styles !!}>
                            <span class="product__badge-item">{{ $label->name }}</span>
                        </span>
                    @endforeach
                @endif
            @endif
        </div>
        <a href="{{ $product->url }}" data-bb-toggle="product-link">
            <img src="{{ RvMedia::getImageUrl($product->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
            <img class="product-thumb-secondary" src="{{ RvMedia::getImageUrl(Arr::get($product->images, 2, $product->image), 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
        </a>
        @if (EcommerceHelper::isCompareEnabled() || theme_option('enable_quick_view', 'yes') === 'yes' || EcommerceHelper::isWishlistEnabled())
            <div class="tpproduct__thumb-action">
                @if (EcommerceHelper::isCompareEnabled())
                    <a
                        class="add-to-compare"
                        href="#"
                        title="{{ __('Add to compare') }}"
                        data-url="{{ route('public.compare.add', $product->getKey()) }}"
                    ><i class="fal fa-exchange"></i>
                    </a>
                @endif
                @if (theme_option('enable_quick_view', 'yes') === 'yes')
                    <a class="quickview" href="#" data-url="{{ route('public.ajax.quick-view', $product->id) }}"><i class="fal fa-eye"></i></a>
                @endif
                @if (EcommerceHelper::isWishlistEnabled())
                    <a class="wishlist add-to-wishlist" href="#"
                       title="{{ __('Add to wishlist') }}"
                       data-url="{{ route('public.wishlist.add', $product->getKey()) }}"><i class="fal fa-heart"></i></a>
                @endif
            </div>
        @endif
    </div>
    <div class="tpproduct__content">
        <h3 class="tpproduct__title text-truncate">
            <a href="{{ $product->url }}" title="{{ $product->name }}" data-bb-toggle="product-link">{{ $product->name }}</a>
        </h3>

        @if (EcommerceHelper::isReviewEnabled())
            <div class="mb-2" style="margin-top: -0.75rem">
                <div class="product-rating-wrapper">
                    <div class="product-rating" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                </div>
                <a class="tpproduct-details__reviewers" href="{{ $product->url }}#reviews">({{ $product->reviews_count }})</a>
            </div>
        @endif

        <div class="tpproduct__priceinfo p-relative">
            <div class="tpproduct__priceinfo-list">
                @include(EcommerceHelper::viewPath('includes.product-price'), [
                    'product' => $product,
                    'priceOriginalClassName' => 'tpproduct__priceinfo-list-oldprice',
                ])
            </div>
            @if(EcommerceHelper::isCartEnabled())
                <div class="tpproduct__cart">
                    @if ($product->variations()->exists())
                        <a data-id="{{ $product->slug }}" href="#" data-url="{{ route('public.ajax.quick-shop', $product->slug) }}" class="button-quick-shop">
                            <i class="fal fa-shopping-cart"></i>
                            <span>{{ __('Select options') }}</span>
                        </a>
                    @else
                        <a data-id="{{ $product->id }}" href="#" data-url="{{ route('public.cart.add-to-cart') }}" class="add-to-cart">
                            <i class="fal fa-shopping-cart"></i>
                            <span>{{ __('Add To Cart') }}</span>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
