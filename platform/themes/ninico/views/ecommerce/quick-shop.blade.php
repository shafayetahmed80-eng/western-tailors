<div class="quickview-content">
    <div class="p-3 product-detail">
        <div class="tpproduct-details__content">
            <div class="tpproduct-details__title-area d-flex align-items-center flex-wrap mb-5">
                <h3 class="tpproduct-details__title">
                    <a href="{{ $product->url }}">{!! BaseHelper::clean($product->name) !!}</a>
                </h3>
            </div>
            <div class="tpproduct-details__price mb-10">
                @include(EcommerceHelper::viewPath('includes.product-price'), ['product' => $product])
            </div>

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
                    class="hidden-product-id"
                    name="id"
                    type="hidden"
                    value="{{ $product->is_variation || !$product->defaultVariation->product_id ? $product->id : $product->defaultVariation->product_id }}"
                />

                <div class="tpproductdot mb-10">
                    @if ($product->variations->isNotEmpty())
                        {!! render_product_swatches($product, [
                            'selected' => $selectedAttrs,
                            'referenceProduct' => $referenceProduct ?? null,
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
                </div>
            </form>
            <a href="{{ $product->url }}">{{ __('View full details') }} <i class="ms-1 fal fa-long-arrow-right"></i></a>
        </div>
    </div>
</div>
