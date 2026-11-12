<section
    class="wishlist-area pt-80 pb-80 wow fadeInUp"
    data-wow-duration=".8s"
    data-wow-delay=".2s"
>
    <div class="container">
        @if (count($products) && $products->loadMissing(['options', 'options.values']))
            <div class="row">
                <div class="col-12">
                    <div class="table-content table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">{{ __('Product') }}</th>
                                    @if (! EcommerceHelper::hideProductPrice() || EcommerceHelper::isCartEnabled())
                                        <th class="product-price">{{ __('Unit Price') }}</th>
                                    @endif
                                    <th class="product-quantity">{{ __('Stock status') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a
                                                class="remove-wishlist-item"
                                                href="#" data-url="{{ route('public.wishlist.remove', $product->id) }}"
                                            >
                                                <i class="fas fa-times"></i>
                                            </a>

                                            <a href="{{ $product->original_product->url }}">
                                                <img
                                                    src="{{ RvMedia::getImageUrl($product->image, 'thumb', false, RvMedia::getDefaultImage()) }}"
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
                                            </div>
                                        </td>
                                        @if (! EcommerceHelper::hideProductPrice() || EcommerceHelper::isCartEnabled())
                                            <td class="product-price">
                                                @include(EcommerceHelper::viewPath('includes.product-price'), ['product' => $product])
                                            </td>
                                        @endif
                                        <td>
                                            {!! $product->stock_status_html !!}
                                        </td>
                                        @if (EcommerceHelper::isCartEnabled())
                                            <td>
                                                <a
                                                    class="tp-btn tp-color-btn add-to-cart"
                                                    data-id="{{ $product->id }}"
                                                    href="#" data-url="{{ route('public.cart.add-to-cart') }}"
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
                                                    {{ __('Add to cart') }}
                                                    <i class="fas fa-shopping-bag"></i>
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {!! $products->links() !!}
                    </div>

                    @if(EcommerceHelper::isWishlistSharingEnabled())
                        <br>
                        <div class="mt-5">
                            <span class="d-inline-block me-1">{{ __('Share:') }}</span>

                            {!! Theme::renderSocialSharing(route('public.wishlist', ['code' => EcommerceHelper::getWishlistCode()])) !!}
                        </div>
                    @endif
                </div>
            </div>
        @else
            <p class="text-center text-muted">{{ __('No product in wishlist!') }}</p>
        @endif
    </div>
</section>
