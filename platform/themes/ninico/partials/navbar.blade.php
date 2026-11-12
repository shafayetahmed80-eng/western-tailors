@if(theme_option('sticky_header_enabled', 'yes') == 'yes')
    <div id="header-sticky" class="logo-area tp-sticky-one mainmenu-5">
        {!! Theme::partial('header-middle') !!}
    </div>
@endif

<div id="header-tab-sticky" class="tp-md-lg-header d-none d-md-block d-xl-none pt-30 pb-30">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 d-flex align-items-center">
                <div class="flex-auto header-canvas">
                    <button class="tp-menu-toggle" title="open">
                        <i class="far fa-bars"></i>
                    </button>
                </div>
                {!! Theme::partial('logo') !!}
            </div>
            @if (is_plugin_active('ecommerce'))
                <div class="col-lg-9 col-md-8">
                    <div class="header-meta-info d-flex align-items-center justify-content-between">
                        {!! Theme::get('headerSearchBar') !!}
                        <div class="header-meta__social d-flex align-items-center ml-25">
                            @if(EcommerceHelper::isCartEnabled())
                                <button class="header-cart p-relative tp-cart-toggle" title="search">
                                    <i class="fal fa-shopping-cart"></i>
                                    <span class="tp-product-count">{{ Cart::instance('cart')->count() }}</span>
                                </button>
                            @endif

                            @if(EcommerceHelper::isCompareEnabled())
                                <a href="{{ route('public.compare') }}" class="header-cart p-relative">
                                    <i class="fal fa-exchange"></i>
                                    <span class="tp-product-compare-count">{{ Cart::instance('compare')->count() }}</span>
                                </a>
                            @endif

                            @auth('customer')
                                <a href="{{ route('customer.overview') }}" title="{{ auth('customer')->user()->name }}"><i class="fal fa-user"></i></a>
                            @else
                                <a href="{{ route('customer.login') }}" title="{{ __('Login') }}"><i class="fal fa-user"></i></a>
                            @endauth

                            @if(EcommerceHelper::isWishlistEnabled())
                                <a href="{{ route('public.wishlist') }}"><i class="fal fa-heart"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<div @if(theme_option('sticky_header_mobile_enabled', 'yes') == 'yes') id="header-mob-sticky" @endif @class(['tp-md-lg-header d-md-none pt-20 pb-20', $headerMobileStickyClass ?? null])>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-3 d-flex align-items-center">
                <div class="flex-auto header-canvas">
                    <button class="tp-menu-toggle" title="open">
                        <i class="far fa-bars"></i>
                    </button>
                </div>
            </div>
            <div class="col-6">
                <div class="text-center">
                    {!! Theme::partial('logo') !!}
                </div>
            </div>
            @if (is_plugin_active('ecommerce'))
                <div class="col-3">
                    <div class="header-meta-info d-flex align-items-center justify-content-end ml-25">
                        <button class="header-cart p-relative tp-search-sidebar-toggle" title="search">
                            <i class="fal fa-search"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="tpsideinfo">
    <button class="tpsideinfo__close">
        {{ __('Close') }}
        <i class="ml-10 fal fa-times"></i>
    </button>

    <div class="tpsideinfo__nabtab mb-4 mt-30">
        {!! Theme::partial('mobile.menu-tab-content') !!}
    </div>

    @if (is_plugin_active('ecommerce'))
        @if(EcommerceHelper::isCompareEnabled())
            <div class="tpsideinfo__wishlist-link">
                <a href="{{ route('public.compare') }}" class="header-cart d-block p-relative">
                    <i class="fal fa-exchange"></i> {{ __('Compare Products') }}
                    <span class="tp-product-compare-count">{{ Cart::instance('compare')->count() }}</span>
                </a>
            </div>
        @endif

        @if (EcommerceHelper::isOrderTrackingEnabled())
            <div class="tpsideinfo__wishlist-link">
                <a href="{{ route('public.orders.tracking') }}">
                    <i class="fal fa-truck"></i> {{ __('Order Tracking') }}
                </a>
            </div>
        @endif

        <div class="tpsideinfo__account-link">
            @auth('customer')
                <a href="{{ route('customer.overview') }}" title="{{ auth('customer')->user()->name }}"><i class="fal fa-user"></i> {{ auth('customer')->user()->name }}</a>
            @else
                <a href="{{ route('customer.login') }}" title="{{ __('Login') }}"><i class="fal fa-user"></i> {{ __('Login / Register') }}</a>
            @endauth
        </div>
    @endif

    <div class="tpsideinfo__switcher navbar-collapse collapse show mb-4" id="navbarSupportedContent" style="">
        <ul class="mb-2 navbar-nav me-auto mb-lg-0">
            {!! Theme::partial('language-switcher', ['mobile' => true]) !!}
            {!! Theme::partial('currency-switcher', ['mobile' => true]) !!}
        </ul>
    </div>
</div>

<div class="body-overlay"></div>

<div class="tpcartinfo tp-cart-info-area p-relative">
    <button class="tpcart__close" title="close">
        <i class="fal fa-times"></i>
    </button>
    <div class="tpcart">
        <h4 class="tpcart__title">{{ __('Your Cart') }}</h4>
        <div class="tpcart__product">
            @include(Theme::getThemeNamespace('views.ecommerce.includes.mini-cart'))
        </div>
        @if ($cartFooterDescription = theme_option('cart_footer_description'))
            <div class="text-center tpcart__free-shipping">
                <span>{!! BaseHelper::clean($cartFooterDescription) !!}</span>
            </div>
        @endif
    </div>
</div>

<div class="tpsideinfo tpsidecategories">
    <button class="tpsideinfo__close">
        {{ __('Close') }}
        <i class="ml-10 fal fa-times"></i>
    </button>

    <div class="tpsideinfo__nabtab mt-30 mb-4">
        {!! Theme::partial('mobile.categories-tab-content', compact('categories')) !!}
    </div>
</div>

<div class="tpsideinfo tpsidesearch">
    <button class="tpsideinfo__close">
        {{ __('Close') }}
        <i class="ml-10 fal fa-times"></i>
    </button>

    @if (is_plugin_active('ecommerce'))
        <div class="text-center tpsideinfo__search pt-35">
            <span class="mb-20 tpsideinfo__search-title">{{ __('What Are You Looking For?') }}</span>
            <form action="{{ route('public.products') }}" class="position-relative form--quick-search" data-url="{{ route('public.ajax.search-products') }}" method="GET">
                <input type="text" name="q" class="input-search-product" placeholder="{{ __('Search Products...') }}" value="{{ BaseHelper::stringify(request()->query('q')) }}" autocomplete="off">
                <button title="search"><i class="fal fa-search"></i></button>
                <div class="panel--search-result"></div>
            </form>
        </div>
    @endif
</div>

<div class="cartbody-overlay"></div>
