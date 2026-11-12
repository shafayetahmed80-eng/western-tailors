@php
    Theme::asset()
        ->usePath()
        ->add('jquery-bar-rating-css', 'plugins/jquery-bar-rating/fontawesome-stars.css');
    Theme::asset()
        ->container('footer')
        ->usePath()
        ->add('jquery-bar-rating-js', 'plugins/jquery-bar-rating/jquery.barrating.min.js');

    Theme::asset()
        ->usePath()
        ->add('lightgallery-css', 'plugins/lightgallery/css/lightgallery.min.css');
    Theme::asset()
        ->container('footer')
        ->usePath()
        ->add('lightgallery-js', 'plugins/lightgallery/js/lightgallery.min.js');

    $flashSale = $product->latestFlashSales()->first();

    Theme::set('pageTitle', '');
@endphp

<div class="product-area row pb-25">
    <div class="col-lg-5 col-md-12">
        @include(Theme::getThemeNamespace('views.ecommerce.includes.product-gallery'))
    </div>
    <div class="col-lg-4 col-md-8">
        <div class="tpproduct-details__content">
            <div class="tpproduct-details__tag-area d-flex align-items-center mb-5">
                @if ($product->isOnSale() && $product->sale_percent)
                    <span class="tpproduct-details__tag" style="background-color: #328f0a; color: #fff">
                        {{ __(':percent% off', ['percent' => $product->sale_percent]) }}
                    </span>
                @endif

                @if ($product->productLabels->isNotEmpty())
                    @foreach ($product->productLabels as $label)
                        <span
                            class="tpproduct-details__tag"
                            {!! $label->css_styles !!}
                        >{{ $label->name }}</span>
                    @endforeach
                @endif

                @if (EcommerceHelper::isReviewEnabled())
                    <div class="tpproduct-details__rating">
                        <div class="product-rating-wrapper">
                            <div
                                class="product-rating"
                                style="width: {{ $product->reviews_avg * 20 }}%"
                            ></div>
                        </div>
                    </div>
                    <a class="tpproduct-details__reviewers" href="{{ $product->url }}#reviews" data-bb-toggle="scroll-to-review">{{ __(':count Reviews', ['count' => $product->reviews_count]) }}</a>
                @endif
            </div>
            <div class="tpproduct-details__title-area d-flex align-items-center flex-wrap mb-5">
                <h3 class="tpproduct-details__title">{!! BaseHelper::clean($product->name) !!}</h3>
                <span class="tpproduct-details__stock mb-0">
                    {!! $product->stock_status_html !!}
                </span>
            </div>
            <div class="tpproduct-details__price mb-30 mt-10">
                @include(EcommerceHelper::viewPath('includes.product-price'), ['product' => $product])
            </div>

            @if ($product->tax_description)
                <div class="tpproduct-details__tax-text mb-20">
                    <small class="text-secondary">
                        {{ $product->tax_description }}
                    </small>
                </div>
            @endif

            {!! apply_filters('ecommerce_before_product_description', null, $product) !!}
            <div class="tpproduct-details__pera">
                <p>{!! BaseHelper::clean($product->description) !!}</p>
            </div>
            {!! apply_filters('ecommerce_after_product_description', null, $product) !!}

            @if ($flashSale)
                <div class="theme-bg p-3 mb-4">
                    <div class="mb-3">
                        <div class="small deal-expire-text mb-2">
                            <p>{!! __('Hurry up! Sale end in') !!}</p>
                        </div>
                        <div class="tpdealcontact__count">
                            <div
                                class="tpdealcontact__countdown"
                                data-countdown="{{ $flashSale->end_date }}"
                            ></div>
                        </div>
                    </div>
                    <div>
                        <div class="small text-muted mb-2">
                            <span>{{ __('Sold: :count', ['count' => $flashSale->pivot->sold . '/' . $flashSale->pivot->quantity]) }}</span>
                        </div>
                        <div class="tpdealcontact__progress">
                            <div class="progress">
                                <div
                                    class="progress-bar"
                                    style="width: {{ $flashSale->pivot->quantity > 0 ? ($flashSale->pivot->sold / $flashSale->pivot->quantity) * 100 : 0 }}%"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form
                class="cart-form"
                method="POST"
                action="{{ route('public.cart.add-to-cart') }}"
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
                @csrf
                <input
                    id="hidden-product-id"
                    name="id"
                    type="hidden"
                    value="{{ $product->is_variation || !$product->defaultVariation->product_id ? $product->id : $product->defaultVariation->product_id }}"
                />

                <div class="tpproductdot mb-30">
                    @if ($product->variations->isNotEmpty())
                        {!! render_product_swatches($product, [
                            'selected' => $selectedAttrs,
                            'view' => Theme::getThemeNamespace('views.ecommerce.attributes.swatches-renderer'),
                        ]) !!}

                        <div
                            class="number-items-available"
                            style="display: none; margin-bottom: 10px;"
                        ></div>
                    @endif

                    {!! render_product_options($product) !!}

                    <input
                        class="hidden-product-id"
                        name="id"
                        type="hidden"
                        value="{{ $product->is_variation || !$product->defaultVariation->product_id ? $product->id : $product->defaultVariation->product_id }}"
                    />

                    {!! apply_filters(ECOMMERCE_PRODUCT_DETAIL_EXTRA_HTML, null, $product) !!}
                </div>

                <div class="tpproduct-details__count d-flex align-items-center flex-wrap gap-2 mb-3">
                    @if (EcommerceHelper::isCartEnabled())
                        <div class="tpproduct-details__quantity">
                            <span class="cart-minus"><i class="far fa-minus"></i></span>
                            <input
                                class="tp-cart-input"
                                name="qty"
                                type="text"
                                value="1"
                            >
                            <span class="cart-plus"><i class="far fa-plus"></i></span>
                        </div>
                        <div class="d-flex gap-2 tpproduct-details__cart">
                            <button
                                class="btn add-to-cart"
                                name="add_to_cart"
                                type="submit"
                                value="1"
                                @disabled($product->isOutOfStock())
                            >
                                <i class="fal fa-shopping-cart"></i>
                                {{ __('Add To Cart') }}
                            </button>

                            @if (EcommerceHelper::isQuickBuyButtonEnabled())
                                <button
                                    class="btn bg-dark buy-now"
                                    name="checkout"
                                    type="submit"
                                    value="1"
                                    @disabled($product->isOutOfStock())
                                >
                                    {{ __('Buy Now') }}
                                </button>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="d-flex align-items-center gap-4 mb-4">
                    @if (EcommerceHelper::isWishlistEnabled())
                        <div>
                            <a
                                class="wishlist add-to-wishlist text-muted small"
                                href="#"
                                title="{{ __('Add to wishlist') }}"
                                data-url="{{ route('public.wishlist.add', $product->getKey()) }}"
                            >
                                <i class="fal fa-heart"></i>
                                {{ __('Wishlist') }}
                            </a>
                        </div>
                    @endif
                    @if (EcommerceHelper::isCompareEnabled())
                        <div>
                            <a
                                class="add-to-compare text-muted small"
                                href="#"
                                title="{{ __('Add to compare') }}"
                                data-url="{{ route('public.compare.add', $product->getKey()) }}"
                            >
                                <i class="fal fa-exchange"></i>
                                {{ __('Compare') }}
                            </a>
                        </div>
                    @endif
                </div>
            </form>

            @if ($product->sku)
                <div class="tpproduct-details__information tpproduct-details__code meta-sku">
                    <p>{{ __('SKU:') }}</p><span class="meta-value">{{ $product->sku }}</span>
                </div>
            @endif

            @if ($product->brand->id)
                <div class="tpproduct-details__information tpproduct-details__brand">
                    <p>{{ __('Brand:') }}</p><span class="meta-value"><a href="{{ $product->brand->url }}" title="{{ $product->brand->name }}">{{ $product->brand->name }}</a></span>
                </div>
            @endif

            @if ($product->categories->isNotEmpty())
                <div class="tpproduct-details__information tpproduct-details__categories">
                    <p>{{ __('Categories:') }}</p>
                    @foreach ($product->categories as $category)
                        <span>
                            <a href="{{ $category->url }}">{{ $category->name . (!$loop->last ? ',' : null) }}</a>
                        </span>
                    @endforeach
                </div>
            @endif
            @if ($product->tags->isNotEmpty())
                <div class="tpproduct-details__information tpproduct-details__tags">
                    <p>{{ __('Tags:') }}</p>
                    @foreach ($product->tags as $tag)
                        <span>
                            <a href="{{ $tag->url }}">{{ $tag->name . (!$loop->last ? ',' : null) }}</a>
                        </span>
                    @endforeach
                </div>
            @endif
            <div class="tpproduct-details__information tpproduct-details__social">
                <p>{{ __('Share:') }}</p>

                {!! Theme::renderSocialSharing($product->url, SeoHelper::getDescription(), $product->image) !!}
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4">
        {!! dynamic_sidebar('product_detail_sidebar') !!}
    </div>
</div>

@if (EcommerceHelper::isEnabledUpSaleProducts())
    @include(EcommerceHelper::viewPath('includes.up-sale-products'), ['parentProduct' => $product])
@endif

@if (EcommerceHelper::isEnabledCrossSaleProducts())
    @include(EcommerceHelper::viewPath('includes.cross-sale-products'), ['parentProduct' => $product])
@endif

<div class="product-details-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tpproduct-details__navtab mb-60">
                    <div class="tpproduct-details__nav mb-30">
                        <ul
                            class="nav nav-tabs pro-details-nav-btn"
                            id="myTabs"
                            role="tablist"
                        >
                            <li
                                class="nav-item"
                                role="presentation"
                            >
                                <button
                                    class="nav-links active"
                                    id="description-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#description"
                                    type="button"
                                    role="tab"
                                    aria-controls="description"
                                    aria-selected="true"
                                >
                                    {{ __('Description') }}
                                </button>
                            </li>
                            @if (EcommerceHelper::isProductSpecificationEnabled() && $product->specificationAttributes->where('pivot.hidden', false)->isNotEmpty())
                                <li
                                    class="nav-item"
                                    role="presentation"
                                >
                                    <button
                                        class="nav-links"
                                        id="av-specification-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#nav-specification"
                                        type="button"
                                        role="tab"
                                        aria-controls="nav-specification"
                                        aria-selected="true"
                                    >
                                        {{ __('Product Specification') }}
                                    </button>
                                </li>
                            @endif
                            @if (EcommerceHelper::isReviewEnabled())
                                <li
                                    class="nav-item"
                                    role="presentation"
                                >
                                    <button
                                        class="nav-links"
                                        id="reviews-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#reviews"
                                        type="button"
                                        role="tab"
                                        aria-controls="reviews"
                                        aria-selected="false"
                                    >
                                        {{ __('Reviews (:count)', ['count' => number_format($product->reviews_count)]) }}
                                    </button>
                                </li>
                            @endif
                            @if (is_plugin_active('faq') && count($product->faq_items) > 0)
                                <li
                                    class="nav-item"
                                    role="presentation"
                                >
                                    <button
                                        class="nav-links"
                                        id="faq-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#faq"
                                        type="button"
                                        role="tab"
                                        aria-controls="faq"
                                        aria-selected="true"
                                    >
                                        {{ __('Questions & Answers') }}
                                    </button>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div
                        class="tab-content tp-content-tab"
                        id="myTabContent-2"
                    >
                        <div
                            class="tab-para tab-pane fade show active"
                            id="description"
                            role="tabpanel"
                            aria-labelledby="description-tab"
                        >
                            <div class="ck-content">
                                {!! BaseHelper::clean($product->content) !!}
                            </div>
                            @if (theme_option('facebook_comment_enabled_in_product', 'no') === 'yes')
                                <div class="postbox__comment mb-65">
                                    <h3 class="postbox__comment-title">{{ __('Comment') }}</h3>
                                    {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, null, $product) !!}
                                </div>
                            @endif
                        </div>
                        @if (EcommerceHelper::isProductSpecificationEnabled() && $product->specificationAttributes->where('pivot.hidden', false)->isNotEmpty())
                            <div class="tab-pane fade" id="nav-specification" role="tabpanel" aria-labelledby="nav-specification-tab" tabindex="0">
                                <div class="tp-product-details-additional-info">
                                    @include(EcommerceHelper::viewPath('includes.product-specification'))
                                </div>
                            </div>
                        @endif
                        @if (EcommerceHelper::isReviewEnabled())
                            <div
                                class="tab-pane fade"
                                id="reviews"
                                role="tabpanel"
                                aria-labelledby="reviews-tab"
                            >
                                @include('plugins/ecommerce::themes.includes.reviews')
                            </div>
                        @endif
                        @if (is_plugin_active('faq') && count($product->faq_items) > 0)
                            <div
                                class="tab-para tab-pane fade"
                                id="faq"
                                role="tabpanel"
                                aria-labelledby="faq-tab"
                            >
                                <div
                                    class="accordion"
                                    id="accordionFaqs"
                                >
                                    @foreach ($product->faq_items as $faq)
                                        <div class="accordion-item tp-accordion-item">
                                            <h2
                                                class="accordion-header tp-accordion-header"
                                                id="heading-{{ $loop->index }}"
                                            >
                                                <button
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-{{ $loop->index }}"
                                                    type="button"
                                                    aria-expanded="true"
                                                    aria-controls="collapse-{{ $loop->index }}"
                                                    @class(['accordion-button', 'collapsed' => !$loop->first])
                                                >
                                                    {!! BaseHelper::clean($faq[0]['value']) !!}
                                                </button>
                                            </h2>
                                            <div
                                                id="collapse-{{ $loop->index }}"
                                                data-bs-parent="#accordionFaqs"
                                                aria-labelledby="heading-{{ $loop->index }}"
                                                @class(['accordion-collapse collapse', 'show' => $loop->first])
                                            >
                                                <div class="accordion-body tp-accordion-body">
                                                    {!! BaseHelper::clean($faq[1]['value']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php($relatedProducts = get_related_products($product, 5))

@if ($relatedProducts->isNotEmpty())
    <div class="related-product-area pt-65 pb-50 related-product-border">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="tpsection mb-40">
                        <h2 class="tpsection__title">{{ __('Related Products') }}</h2>
                    </div>
                </div>
                @if ($relatedProducts->count() > 1)
                    <div class="col-sm-6">
                        <div class="tprelated__arrow d-flex align-items-center justify-content-end mb-40">
                            <div class="tprelated__prv"><i class="far fa-long-arrow-left"></i></div>
                            <div class="tprelated__nxt"><i class="far fa-long-arrow-right"></i></div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="swiper-container related-product-active">
                <div class="swiper-wrapper">
                    @foreach ($relatedProducts as $product)
                        <div class="swiper-slide">
                            @include(Theme::getThemeNamespace('views.ecommerce.includes.product-item'))
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @if (theme_option('enable_quick_view', 'yes') === 'yes')
        @include(Theme::getThemeNamespace('views.ecommerce.includes.quick-view-modal'))
    @endif
@endif
