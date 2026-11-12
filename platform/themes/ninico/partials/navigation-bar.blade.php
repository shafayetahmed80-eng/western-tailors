<div class="navigation-bar">
    <ul class="navigation-bar__list">
        <li>
            <a href="{{ BaseHelper::getHomepageUrl() }}" class="text-truncate" title="{{ __('Home') }}">
                <i class="fal fa-home"></i>
                @if($showMenuLabel = theme_option('bottom_mobile_menu_show_label', 'yes') === 'yes')
                    <span>{{ __('Home') }}</span>
                @endif
            </a>
        </li>
        <li>
            <a role="button" href="javascript:void(0)" class="tp-categories-sidebar-toggle text-truncate" title="{{ __('Categories') }}">
                <i class="fal fa-list"></i>
                @if($showMenuLabel)
                    <span>{{ __('Categories') }}</span>
                @endif
            </a>
        </li>
        @if (EcommerceHelper::isCartEnabled())
            <li>
                <a role="button" href="javascript:void(0)" class="tp-cart-toggle text-truncate" title="{{ __('Cart') }}">
                    <div class="header-cart p-relative">
                        <i class="fal fa-shopping-cart"></i>
                        <span class="tp-product-count text-white">{{ Cart::instance('cart')->count() }}</span>
                    </div>
                    @if($showMenuLabel)
                        <span>{{ __('Cart') }}</span>
                    @endif
                </a>
            </li>
        @endif

        @if(EcommerceHelper::isWishlistEnabled())
            <li>
                <a href="{{ route('public.wishlist') }}" class="text-truncate" title="{{ __('Wishlist') }}">
                    <div class="header-cart p-relative">
                        <i class="fal fa-heart"></i>
                        <span class="tp-product-count tp-product-wishlist-count text-white" style="inset-inline-end: 2px">{{ Cart::instance('wishlist')->count() }}</span>
                    </div>
                    @if($showMenuLabel)
                        <span>{{ __('Wishlist') }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('customer.overview') }}" class="text-truncate" title="{{ __('Account') }}">
                    <i class="fal fa-user"></i>
                    @if($showMenuLabel)
                        <span>{{ __('Account') }}</span>
                    @endif
                </a>
            </li>
        @endif
    </ul>
</div>
