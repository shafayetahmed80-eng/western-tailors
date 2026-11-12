@foreach($products as $product)
    <div class="tpproduct row mb-40 product-item"
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
        <div class="col-lg-4 col-md-12">
            <div class="tpproduct__thumb">
                <div class="tpproduct__thumbitem p-relative">
                    @if ($product->productLabels->isNotEmpty())
                        <div class="product__badge-list">
                            @foreach ($product->productLabels as $label)
                                <span class="tpproduct__thumb-topsall" {!! $label->css_styles !!}>
                                    <span class="product__badge-item">{{ $label->name }}</span>
                                </span>
                            @endforeach
                        </div>
                    @endif
                    <a href="{{ $product->url }}" data-bb-toggle="product-link">
                        <img src="{{ RvMedia::getImageUrl($product->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
                        <img class="thumbitem-secondary" src="{{ RvMedia::getImageUrl(Arr::get($product->images, 2, $product->image), 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="filter-product ml-20 pt-30">
                <h3 class="filter-product-title">
                    <a href="{{ $product->url }}" data-bb-toggle="product-link">{{ $product->name }}</a>
                </h3>
                <div class="tpproduct__amount">
                    @include(EcommerceHelper::viewPath('includes.product-price'), [
                        'product' => $product,
                        'priceOriginalClassName' => 'tpproduct__amount old',
                    ])
                </div>
                @if (EcommerceHelper::isReviewEnabled())
                    <div class="tpproduct__rating mb-15">
                        <div class="product-rating-wrapper">
                            <div class="product-rating" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                        </div>
                        <span>({{ $product->reviews_count }})</span>
                    </div>
                @endif
                <p>{!! BaseHelper::clean(Str::limit($product->description, 200)) !!}</p>
                <div class="tpproduct__action">
                    @if (EcommerceHelper::isCompareEnabled())
                        <a class="add-to-compare" href="#"
                           title="{{ __('Add to compare') }}"
                           data-url="{{ route('public.compare.add', $product->getKey()) }}">
                            <i class="fal fa-exchange"></i>
                        </a>
                    @endif
                    @if (theme_option('enable_quick_view', 'yes') === 'yes')
                        <a class="quickview" href="#" data-url="{{ route('public.ajax.quick-view', $product->id) }}">
                            <i class="fal fa-eye"></i>
                        </a>
                    @endif
                    @if (EcommerceHelper::isWishlistEnabled())
                        <a class="wishlist add-to-wishlist" href="#"
                           title="{{ __('Add to wishlist') }}"
                           data-url="{{ route('public.wishlist.add', $product->getKey()) }}">
                            <i class="fal fa-heart"></i>
                        </a>
                    @endif
                    @if(EcommerceHelper::isCartEnabled())
                        @if ($product->variations()->exists())
                            <a href="#" data-url="{{ route('public.ajax.quick-shop', $product->slug) }}" class="button-quick-shop" data-id="{{ $product->id }}">
                                <i class="fal fa-shopping-cart"></i>
                            </a>
                        @else
                            <a class="add-to-cart" href="#" data-url="{{ route('public.cart.add-to-cart') }}" data-id="{{ $product->id }}">
                                <i class="fal fa-shopping-cart"></i>
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach

@if (theme_option('enable_quick_view', 'yes') === 'yes')
    @include(Theme::getThemeNamespace('views.ecommerce.includes.quick-view-modal'))
@endif
