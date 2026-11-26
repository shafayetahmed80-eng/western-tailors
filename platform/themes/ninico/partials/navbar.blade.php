@php
    $isHome = request()->is('/') || request()->routeIs('public.index');
    $catMap = collect();
    if (is_plugin_active('ecommerce')) {
        $catMap = \Botble\Ecommerce\Models\ProductCategory::query()
            ->whereIn('id', [38, 72, 21, 33, 19])
            ->with('slugable')
            ->get()
            ->keyBy('id');
    }
    $sherwaniUrl = optional($catMap->get(38))->url ?: url('products');
    $suitsUrl = optional($catMap->get(72) ?: $catMap->get(21))->url ?: url('products');
    $gurkhaUrl = optional($catMap->get(33))->url ?: url('products');
    $tuxedoUrl = optional($catMap->get(19))->url ?: url('products');
@endphp

{{-- Sticky Mobile & Tablet Atelier Header (< 1200px) --}}
<div class="wb-mobile-header d-xl-none">
    <div class="wb-mobile-header__inner">
        {{-- Left: Hamburger Menu --}}
        <button type="button" class="wb-mobile-header__btn tp-menu-toggle" aria-label="{{ __('Open Menu') }}">
            <svg width="21" height="21" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5h16.5M3.75 12h16.5M3.75 16.5h11.25" />
            </svg>
        </button>

        {{-- Center: Crest Emblem + Wordmark --}}
        <a href="{{ BaseHelper::getHomepageUrl() }}" @if($isHome) data-wb-scroll="hero" @endif class="wb-brand wb-brand--mobile" aria-label="{{ theme_option('site_title', 'Western Bespoke') }}">
            <svg class="wb-brand__crest" viewBox="0 0 48 30" fill="none" aria-hidden="true">
                <path d="M24 3L27 9L34 7L31 15H17L14 7L21 9L24 3Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                <path d="M16 18.5C16 23.5 20 26.5 24 28C28 26.5 32 23.5 32 18.5H16Z" stroke="currentColor" stroke-width="1.5"/>
            </svg>
            <span class="wb-brand__wordmark">Western Bespoke</span>
        </a>

        {{-- Right: Search + Shopping Bag with Live Badge --}}
        <div class="wb-mobile-header__right">
            @if (is_plugin_active('ecommerce'))
                <button type="button" class="wb-mobile-header__btn tp-search-sidebar-toggle" aria-label="{{ __('Search') }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="7"></circle>
                        <path stroke-linecap="round" d="M20 20l-3.5-3.5"></path>
                    </svg>
                </button>
                @if(EcommerceHelper::isCartEnabled())
                    <button type="button" class="wb-mobile-header__btn tp-cart-toggle" aria-label="{{ __('Open Bag') }}">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                        </svg>
                        <span class="header-cart wb-cart-count-host"><span class="tp-product-count wb-bag-badge">{{ Cart::instance('cart')->count() }}</span></span>
                    </button>
                @endif
            @endif
        </div>
    </div>
</div>

{{-- Full-Height Deep Emerald Navigation Drawer --}}
<div class="tpsideinfo wb-nav-drawer">
    <div class="wb-nav-drawer__top">
        <div class="wb-nav-drawer__header">
            <span class="wb-nav-drawer__brand">Western Bespoke</span>
            <button type="button" class="tpsideinfo__close wb-nav-drawer__close" aria-label="{{ __('Close Menu') }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <p class="wb-nav-drawer__eyebrow">{{ __('Atelier Menu') }}</p>

        <ul class="wb-nav-drawer__links">
            <li>
                <a href="{{ $isHome ? '#archive' : url('products') }}" @if($isHome) data-wb-drawer-scroll="archive" @endif>
                    {{ __('The Atelier Archive') }}
                </a>
            </li>
            <li>
                <a href="{{ $sherwaniUrl }}" @if($isHome) data-wb-drawer-cat="sherwani" @endif>
                    {{ __('Wedding Sherwani') }}
                </a>
            </li>
            <li>
                <a href="{{ $suitsUrl }}" @if($isHome) data-wb-drawer-cat="suits" @endif>
                    {{ __('Bespoke Suits') }}
                </a>
            </li>
            <li>
                <a href="{{ $gurkhaUrl }}" @if($isHome) data-wb-drawer-cat="gurkha" @endif>
                    {{ __('Gurkha Trousers') }}
                </a>
            </li>
            <li>
                <a href="{{ $tuxedoUrl }}" @if($isHome) data-wb-drawer-cat="tuxedos" @endif>
                    {{ __('Royal Tuxedos') }}
                </a>
            </li>
            <li>
                <a href="{{ $isHome ? '#crafted' : BaseHelper::getHomepageUrl() . '#crafted' }}" @if($isHome) data-wb-drawer-scroll="crafted" @endif>
                    {{ __('Crafted by Hand') }}
                </a>
            </li>
            @if (is_plugin_active('ecommerce'))
                <li>
                    <a href="{{ route('public.products') }}">
                        {{ __('All Creations') }}
                    </a>
                </li>
            @endif
        </ul>

        @if (is_plugin_active('ecommerce'))
            <div class="wb-nav-drawer__meta">
                @auth('customer')
                    <a href="{{ route('customer.overview') }}"><i class="fal fa-user"></i> {{ auth('customer')->user()->name }}</a>
                @else
                    <a href="{{ route('customer.login') }}"><i class="fal fa-user"></i> {{ __('Client Account / Sign In') }}</a>
                @endauth

                @if (EcommerceHelper::isOrderTrackingEnabled())
                    <a href="{{ route('public.orders.tracking') }}"><i class="fal fa-truck"></i> {{ __('Track Bespoke Order') }}</a>
                @endif
            </div>
        @endif
    </div>

    <div class="wb-nav-drawer__footer">
        <button type="button" onclick="window.closeAtelierNavDrawer && window.closeAtelierNavDrawer(); window.openAtelierFitting && window.openAtelierFitting('Charcoal Double-Breasted Suit');" class="wb-btn-brass w-100">
            {{ __('Book Private Fitting') }}
        </button>
        <p class="wb-nav-drawer__salon-note">{{ __('Banani & Dhanmondi Salons, Dhaka') }}</p>
    </div>
</div>

<div class="body-overlay"></div>

{{-- Atelier Bag Slide-Out Drawer (Real Botble Cart) --}}
<div class="tpcartinfo tp-cart-info-area wb-bag-drawer p-relative">
    <button class="tpcart__close wb-bag-drawer__close" title="{{ __('Close') }}" aria-label="{{ __('Close Bag') }}">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <div class="tpcart">
        <div class="wb-bag-drawer__head">
            <p class="wb-eyebrow mb-1">{{ __('Your Selection') }}</p>
            <h4 class="tpcart__title wb-bag-drawer__title mb-0">{{ __('Atelier Bag') }}</h4>
        </div>
        <div class="tpcart__product">
            @include(Theme::getThemeNamespace('views.ecommerce.includes.mini-cart'))
        </div>
        @if ($cartFooterDescription = theme_option('cart_footer_description'))
            <div class="text-center tpcart__free-shipping wb-bag-drawer__note">
                <span>{!! BaseHelper::clean($cartFooterDescription) !!}</span>
            </div>
        @endif
    </div>
</div>

{{-- Categories Slide Drawer (preserved for compatibility) --}}
<div class="tpsideinfo tpsidecategories">
    <button class="tpsideinfo__close">
        {{ __('Close') }}
        <i class="ml-10 fal fa-times"></i>
    </button>

    <div class="tpsideinfo__nabtab mt-30 mb-4">
        {!! Theme::partial('mobile.categories-tab-content', compact('categories')) !!}
    </div>
</div>

{{-- Search Slide Drawer --}}
<div class="tpsideinfo tpsidesearch wb-search-drawer">
    <button class="tpsideinfo__close wb-search-drawer__close">
        {{ __('Close') }}
        <i class="ml-10 fal fa-times"></i>
    </button>

    @if (is_plugin_active('ecommerce'))
        <div class="text-center tpsideinfo__search pt-35">
            <p class="wb-eyebrow mb-1">{{ __('The Atelier Archive') }}</p>
            <span class="mb-20 tpsideinfo__search-title d-block">{{ __('Search Bespoke Pieces') }}</span>
            <form action="{{ route('public.products') }}" class="position-relative form--quick-search" data-url="{{ route('public.ajax.search-products') }}" method="GET">
                <input type="text" name="q" class="input-search-product" placeholder="{{ __('Sherwani, Tuxedo, Gurkha, Suit...') }}" value="{{ BaseHelper::stringify(request()->query('q')) }}" autocomplete="off">
                <button title="{{ __('Search') }}"><i class="fal fa-search"></i></button>
                <div class="panel--search-result"></div>
            </form>
        </div>
    @endif
</div>

<div class="cartbody-overlay"></div>
