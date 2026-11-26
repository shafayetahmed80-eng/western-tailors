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

<header class="wb-site-header">
    {{-- Desktop Luxury Atelier Header (xl and up) --}}
    <div class="wb-desktop-bar d-none d-xl-block">
        <div class="container">
            <div class="wb-desktop-bar__inner">
                {{-- Brand Crest + Wordmark --}}
                <a href="{{ BaseHelper::getHomepageUrl() }}" class="wb-brand" aria-label="{{ theme_option('site_title', 'Western Bespoke') }}">
                    <svg class="wb-brand__crest" viewBox="0 0 48 30" fill="none" aria-hidden="true">
                        <path d="M24 3L27 9L34 7L31 15H17L14 7L21 9L24 3Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        <path d="M16 18.5C16 23.5 20 26.5 24 28C28 26.5 32 23.5 32 18.5H16Z" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                    <span class="wb-brand__wordmark">Western Bespoke</span>
                </a>

                {{-- Center Editorial Navigation --}}
                <nav class="wb-desktop-nav" aria-label="{{ __('Primary Navigation') }}">
                    <a href="{{ $isHome ? '#archive' : url('products') }}" @if($isHome) data-wb-scroll="archive" @endif class="wb-desktop-nav__link">{{ __('The Archive') }}</a>
                    <a href="{{ $sherwaniUrl }}" @if($isHome) data-wb-cat="sherwani" @endif class="wb-desktop-nav__link">{{ __('Sherwani') }}</a>
                    <a href="{{ $suitsUrl }}" @if($isHome) data-wb-cat="suits" @endif class="wb-desktop-nav__link">{{ __('Bespoke Suits') }}</a>
                    <a href="{{ $gurkhaUrl }}" @if($isHome) data-wb-cat="gurkha" @endif class="wb-desktop-nav__link">{{ __('Gurkha') }}</a>
                    <a href="{{ $tuxedoUrl }}" @if($isHome) data-wb-cat="tuxedos" @endif class="wb-desktop-nav__link">{{ __('Tuxedos') }}</a>
                    <a href="{{ $isHome ? '#crafted' : BaseHelper::getHomepageUrl() . '#crafted' }}" @if($isHome) data-wb-scroll="crafted" @endif class="wb-desktop-nav__link">{{ __('Our Craft') }}</a>
                    <a href="{{ is_plugin_active('ecommerce') ? route('public.products') : url('products') }}" class="wb-desktop-nav__link">{{ __('All Creations') }}</a>
                </nav>

                {{-- Right Actions: Search, Book Fitting, Account, Bag --}}
                <div class="wb-desktop-actions">
                    @if (is_plugin_active('ecommerce'))
                        <button type="button" class="wb-icon-btn tp-search-sidebar-toggle" title="{{ __('Search') }}" aria-label="{{ __('Search') }}">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7"></circle>
                                <path stroke-linecap="round" d="M20 20l-3.5-3.5"></path>
                            </svg>
                        </button>
                    @endif

                    <button type="button" onclick="window.openAtelierFitting && window.openAtelierFitting('Charcoal Double-Breasted Suit')" class="wb-header-cta">
                        {{ __('Book Fitting') }}
                    </button>

                    @if (is_plugin_active('ecommerce'))
                        @auth('customer')
                            <a href="{{ route('customer.overview') }}" class="wb-icon-btn" title="{{ auth('customer')->user()->name }}" aria-label="{{ __('Account') }}">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" />
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('customer.login') }}" class="wb-icon-btn" title="{{ __('Login') }}" aria-label="{{ __('Login') }}">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" />
                                </svg>
                            </a>
                        @endauth

                        @if(EcommerceHelper::isCartEnabled())
                            <button type="button" class="wb-icon-btn tp-cart-toggle" title="{{ __('Atelier Bag') }}" aria-label="{{ __('Open Bag') }}">
                                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                                </svg>
                                <span class="header-cart wb-cart-count-host"><span class="tp-product-count wb-bag-badge">{{ Cart::instance('cart')->count() }}</span></span>
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>

{!! Theme::partial('navbar') !!}
