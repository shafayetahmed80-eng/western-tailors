<section
    class="cart-area pt-80 pb-80 wow fadeInUp"
    data-wow-duration=".8s"
    data-wow-delay=".2s"
>
    <div class="container">
        @if ($products->isNotEmpty())
            <div class="row">
                <div class="col-12">
                    <form
                        class="cart-form"
                        action="{{ route('public.cart.update') }}"
                        method="post"
                    >
                        @csrf
                        <div class="table-content table-responsive bb-ecommerce-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">{{ __('Product') }}</th>
                                        <th class="product-price">{{ __('Price') }}</th>
                                        <th class="product-quantity">{{ __('Quantity') }}</th>
                                        <th class="product-subtotal">{{ __('Total') }}</th>
                                        <th class="product-remove">{{ __('Remove') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::instance('cart')->content() as $key => $item)
                                        @php($product = $products->find($item->id))

                                        @continue(! $product)

                                        @php($shouldShowPrice = (! EcommerceHelper::hideProductPrice() || EcommerceHelper::isCartEnabled()) && (! EcommerceHelper::hideProductPriceWhenZero() || $item->price > 0))

                                        <tr>
                                            <input
                                                name="items[{{ $key }}][rowId]"
                                                type="hidden"
                                                value="{{ $item->rowId }}"
                                            >

                                            <td class="product-thumbnail">
                                                <a href="{{ $product->original_product->url }}">
                                                    <img
                                                        src="{{ RvMedia::getImageUrl(Arr::get($item->options, 'image'), 'thumb', false, RvMedia::getDefaultImage()) }}"
                                                        alt="{{ $product->original_product->name }}"
                                                    >
                                                </a>

                                                <div>
                                                    <a
                                                        class="product-name"
                                                        href="{{ $product->original_product->url }}"
                                                    >{{ $product->original_product->name }}</a>

                                                    @if (is_plugin_active('marketplace') && $product->original_product->store->id)
                                                        <div class="variation-group">
                                                            <span class="text-secondary">{{ __('Vendor:') }}</span>
                                                            <a
                                                                href="{{ $product->original_product->store->url }}">{{ $product->original_product->store->name }}</a>
                                                        </div>
                                                    @endif

                                                    @if ($attributes = Arr::get($item->options, 'attributes'))
                                                        <p class="mb-0">
                                                            <small>{{ $attributes }}</small>
                                                        </p>
                                                    @endif

                                                    @if (!empty(Arr::get($item->options, 'options')))
                                                        {!! render_product_options_html(
                                                            Arr::get($item->options, 'options'),
                                                            $product->original_product->front_sale_price_with_taxes,
                                                        ) !!}
                                                    @endif

                                                    @include(
                                                        'plugins/ecommerce::themes.includes.cart-item-options-extras',
                                                        ['options' => $item->options]
                                                    )

                                                    {!! apply_filters('ecommerce_cart_after_item_content', null, $item) !!}
                                                </div>
                                            </td>
                                            <td class="product-price" data-title="{{ __('Price') }}">
                                                @if ($shouldShowPrice)
                                                    <span class="amount">{{ format_price($item->price) }}</span>
                                                    @if ($item->price < $product->price)
                                                        &nbsp;<small><del>{{ format_price($product->price) }}</del></small>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="product-quantity" data-title="{{ __('Quantity') }}">
                                                <span class="cart-minus">-</span>
                                                <input
                                                    class="cart-input"
                                                    name="items[{{ $key }}][values][qty]"
                                                    type="number"
                                                    value="{{ $item->qty }}"
                                                    step="1"
                                                    min="1"
                                                    max="{{ $product->with_storehouse_management ? $product->quantity : 1000 }}"
                                                />
                                                <span class="cart-plus">+</span>
                                            </td>
                                            <td class="product-subtotal" data-title="{{ __('Total') }}">
                                                @if ($shouldShowPrice)
                                                    <span
                                                        class="amount">{{ format_price($item->price * $item->qty) }}</span>
                                                @endif
                                            </td>
                                            <td class="product-remove" data-title="{{ __('Remove') }}">
                                                <a
                                                    class="remove-cart-item"
                                                    data-url="{{ route('public.cart.remove', $item->rowId) }}"
                                                    href="#"
                                                    data-product-id="{{ $product->id }}"
                                                    data-product-name="{{ $product->name }}"
                                                    data-product-price="{{ $product->price }}"
                                                    data-product-sku="{{ $product->sku }}"
                                                    data-product-quantity="{{ $item->qty }}"
                                                    @if($product->brand)
                                                    data-product-brand="{{ $product->brand->name }}"
                                                    @endif
                                                    @if($product->categories->isNotEmpty())
                                                    data-product-categories="{{ $product->categories->pluck('name')->implode(',') }}"
                                                    @endif
                                                >
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="coupon-all">
                                    <div class="coupon">
                                        <input
                                            class="input-text"
                                            id="coupon_code"
                                            name="coupon_code"
                                            type="text"
                                            value=""
                                            placeholder="{{ __('Coupon code') }}"
                                        >
                                        <button
                                            class="tp-btn tp-color-btn btn-apply-coupon-code"
                                            data-url="{{ route('public.coupon.apply') }}"
                                            type="button"
                                        >{{ __('Apply Coupon') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-5">
                                <div class="cart-page-total">
                                    <h2>{{ __('Cart totals') }}</h2>
                                    <ul class="mb-20">
                                        <li>{{ __('Subtotal') }}
                                            <span>{{ format_price(Cart::instance('cart')->rawSubTotal()) }}</span></li>
                                        @if (EcommerceHelper::isTaxEnabled())
                                            <li>{{ __('Tax') }}
                                                <span>{{ format_price(Cart::instance('cart')->rawTax()) }}</span></li>
                                        @endif
                                        @if ($couponDiscountAmount > 0 && session('applied_coupon_code'))
                                            <li>
                                                {!! BaseHelper::clean(__('Coupon code: :code', ['code' => '<strong>' . session('applied_coupon_code') . '</strong>'])) !!}&nbsp;
                                                <small>(<a
                                                        class="btn-remove-coupon-code"
                                                        data-loading-text="{{ __('Removing...') }}"
                                                        href="#" data-url="{{ route('public.coupon.remove') }}"
                                                    >{{ __('Remove') }}</a>)</small>

                                                <span>{{ format_price($couponDiscountAmount) }}</span>
                                            </li>
                                        @endif
                                        @if ($promotionDiscountAmount)
                                            <li>
                                                {{ __('Discount promotion') }}

                                                <span>{{ format_price($promotionDiscountAmount) }}</span>
                                            </li>
                                        @endif
                                        <li>{{ __('Total') }}
                                            <small>{{ __('(Shipping fees not included)') }}</small>
                                            <span>{{ $promotionDiscountAmount + $couponDiscountAmount > Cart::instance('cart')->rawTotal() ? format_price(0) : format_price(Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount) }}</span>
                                        </li>
                                    </ul>
                                    <a
                                        class="tp-btn tp-color-btn banner-animation"
                                        href="{{ route('public.checkout.information', session('tracked_start_checkout')) }}"
                                    >{{ __('Proceed to Checkout') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <p class="text-center text-muted">{{ __('Your cart is empty!') }}</p>
        @endif
    </div>
</section>
