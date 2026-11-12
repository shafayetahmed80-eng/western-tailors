@if (is_plugin_active('ecommerce') && EcommerceHelper::isCartEnabled())
    <div class="tpcart__product-list">
        <ul>
            @php($products = Cart::instance('cart')->products())
            @forelse(Cart::instance('cart')->content() as $key => $cartItem)
                @php($product = $products->find($cartItem->id))

                @continue(! $product)

                <li>
                    <div class="tpcart__item">
                        <div class="tpcart__img">
                            <img src="{{ RvMedia::getImageUrl(Arr::get($cartItem->options, 'image'), 'thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->original_product->name }}">

                            <div class="tpcart__del">
                                <a
                                    href="#"
                                    data-url="{{ route('public.cart.remove', $cartItem->rowId) }}"
                                    class="remove-cart-item"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-price="{{ $product->price }}"
                                    data-product-sku="{{ $product->sku }}"
                                    data-product-quantity="{{ $cartItem->qty }}"
                                    {!! $product->brand ? 'data-product-brand="' . e($product->brand->name) . '"' : '' !!}
                                    {!! $product->categories->isNotEmpty() ? 'data-product-categories="' . e($product->categories->pluck('name')->implode(',')) . '"' : '' !!}
                                ><i class="far fa-times-circle"></i></a>
                            </div>
                        </div>
                        <div class="tpcart__content">
                            <span class="tpcart__content-title">
                               <a href="{{ $product->original_product->url }}">{{ $product->original_product->name }}</a>
                            </span>
                            @php($shouldShowPrice = (! EcommerceHelper::hideProductPrice() || EcommerceHelper::isCartEnabled()) && (! EcommerceHelper::hideProductPriceWhenZero() || $cartItem->price > 0))
                            <div class="tpcart__cart-price">
                                @if ($shouldShowPrice)
                                    <span class="quantity">{{ __(':qty x', ['qty' => $cartItem->qty]) }}</span>
                                    <span class="new-price">
                                        <bdi>
                                            {{ format_price($cartItem->price) }}
                                            @if ($product->front_sale_price != $product->price)
                                                <span class="tpproduct__priceinfo-list-oldprice">{{ format_price($product->price) }}</span>
                                            @endif
                                        </bdi>
                                    </span>
                                @endif

                                <span class="d-inline-block mb-0">
                                    {{ Arr::get($cartItem->options, 'attributes', '') }}
                                </span>
                                @if (EcommerceHelper::isEnabledProductOptions() && ! empty($cartItem->options['options']))
                                    {!! render_product_options_html($cartItem->options['options'], $product->original_price) !!}
                                @endif

                                @include('plugins/ecommerce::themes.includes.cart-item-options-extras', ['options' => $cartItem->options])

                                {!! apply_filters('ecommerce_cart_after_item_content', null, $cartItem) !!}
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="text-center small text-muted">{{ __('Your cart is empty!') }}</li>
            @endforelse
        </ul>
    </div>

    @if (Cart::instance('cart')->isNotEmpty() && Cart::instance('cart')->products()->isNotEmpty())
        <div class="tpcart__checkout">
            <div class="tpcart__total-price">
                <div class="text-black d-flex justify-content-between align-items-center mb-2">
                    <span>{{ __('Subtotal:') }}</span>
                    <span>{{ format_price(Cart::instance('cart')->rawSubTotal()) }}</span>
                </div>
                <div class="text-black d-flex justify-content-between align-items-center mb-2">
                    <span>{{ __('Tax:') }}</span>
                    <span>{{ format_price(Cart::instance('cart')->rawTax()) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>{{ __('Total:') }}</span>
                    <span class="heilight-price">{{ format_price(Cart::instance('cart')->rawSubTotal() + Cart::instance('cart')->rawTax()) }}</span>
                </div>
            </div>
            <div class="tpcart__checkout-btn">
                <a class="tpcart-btn mb-10" href="{{ route('public.cart') }}">{{ __('View Cart') }}</a>
                <a class="tpcheck-btn" href="{{ route('public.checkout.information', OrderHelper::getOrderSessionToken()) }}">{{ __('Checkout') }}</a>
            </div>
        </div>
    @endif
@endif
