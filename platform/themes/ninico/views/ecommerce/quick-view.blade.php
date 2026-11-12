<div class="quickview-content">
    <div class="thumbnails">
        <div class="images">
            @foreach ($productImages as $image)
                <div class="thumbnail">
                    <img
                        src="{{ RvMedia::getImageUrl($image, 'medium') }}"
                        alt="{{ $product->name }}"
                        loading="lazy"
                    />
                </div>
            @endforeach
        </div>
    </div>
    <div class="p-3 product-detail">
        <div class="tpproduct-details__content">
            <div class="tpproduct-details__tag-area d-flex align-items-center mb-5">
                @foreach ($product->productLabels as $label)
                    <span
                        class="tpproduct-details__tag"
                        {!! $label->css_styles !!}
                    >{{ $label->name }}</span>
                @endforeach
                @if (EcommerceHelper::isReviewEnabled())
                    <div class="tpproduct-details__rating">
                        <div class="product-rating-wrapper">
                            <div
                                class="product-rating"
                                style="width: {{ $product->reviews_avg * 20 }}%"
                            ></div>
                        </div>
                    </div>
                    <a
                        class="tpproduct-details__reviewers"
                        href="{{ $product->url }}#reviews"
                    >{{ __(':count Reviews', ['count' => $product->reviews_count]) }}</a>
                @endif
            </div>
            <div class="tpproduct-details__title-area d-flex align-items-center flex-wrap mb-5">
                <h3 class="tpproduct-details__title">
                    <a href="{{ $product->url }}">{!! BaseHelper::clean($product->name) !!}</a>
                </h3>
                <span class="tpproduct-details__stock mb-0">
                    {!! $product->stock_status_html !!}
                </span>
            </div>
            <div class="tpproduct-details__price mb-10 mt-10">
                @include(EcommerceHelper::viewPath('includes.product-price'), ['product' => $product])
            </div>

            {!! apply_filters('ecommerce_before_product_description', null, $product) !!}
            <div class="tpproduct-details__pera">
                <p>{!! BaseHelper::clean($product->description) !!}</p>
            </div>
            {!! apply_filters('ecommerce_after_product_description', null, $product) !!}
            <form
                class="cart-form"
                method="POST"
                action="{{ route('public.cart.add-to-cart') }}"
            >
                @csrf
                <input
                    class="hidden-product-id"
                    name="id"
                    type="hidden"
                    value="{{ $product->is_variation || !$product->defaultVariation->product_id ? $product->id : $product->defaultVariation->product_id }}"
                />

                <div class="tpproductdot mb-10">
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

                    {!! apply_filters(ECOMMERCE_PRODUCT_DETAIL_EXTRA_HTML, null, $product) !!}
                </div>

                <div class="tpproduct-details__count d-flex align-items-center flex-wrap gap-2 mb-25">
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
                        </div>
                    @endif
                    @if (EcommerceHelper::isWishlistEnabled())
                        <div class="tpproduct-details__wishlist">
                            <a
                                class="wishlist add-to-wishlist"
                                href="#" data-url="{{ route('public.wishlist.add', $product->getKey()) }}"
                            >
                                <i class="fal fa-heart"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
