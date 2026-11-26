@php
    $isHome = request()->is('/') || request()->routeIs('public.index');
    $isCatalog = request()->is('products*') || request()->is('product-categories*') || request()->is('product-collections*');
@endphp

<nav class="navigation-bar wb-bottom-nav" aria-label="{{ __('Mobile Bottom Navigation') }}">
    {{-- 1. Home --}}
    <a
        href="{{ BaseHelper::getHomepageUrl() }}"
        @if($isHome) data-wb-scroll="hero" @endif
        data-wb-tab="home"
        class="wb-bottom-nav__item {{ $isHome ? 'is-active' : '' }}"
    >
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
        </svg>
        <span>{{ __('Home') }}</span>
    </a>

    {{-- 2. Archive --}}
    <a
        href="{{ $isHome ? '#archive' : (is_plugin_active('ecommerce') ? route('public.products') : url('products')) }}"
        @if($isHome) data-wb-scroll="archive" @endif
        data-wb-tab="archive"
        class="wb-bottom-nav__item {{ $isCatalog ? 'is-active' : '' }}"
    >
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
        </svg>
        <span>{{ __('Archive') }}</span>
    </a>

    {{-- 3. Highlighted Center Tab: Book Fit (Antique Brass) --}}
    <button
        type="button"
        onclick="window.openAtelierFitting && window.openAtelierFitting('Charcoal Double-Breasted Suit')"
        class="wb-bottom-nav__center"
    >
        <span class="wb-bottom-nav__center-circle">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
        </span>
        <span class="wb-bottom-nav__center-label">{{ __('Book Fit') }}</span>
    </button>

    {{-- 4. Bag with Live Badge --}}
    @if (EcommerceHelper::isCartEnabled())
        <button
            type="button"
            class="wb-bottom-nav__item tp-cart-toggle"
            aria-label="{{ __('Open Bag') }}"
        >
            <span class="wb-bottom-nav__bag-wrap header-cart wb-cart-count-host">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                </svg>
                <span class="tp-product-count wb-bottom-nav__badge">{{ Cart::instance('cart')->count() }}</span>
            </span>
            <span>{{ __('Bag') }}</span>
        </button>
    @else
        <a href="{{ route('customer.overview') }}" class="wb-bottom-nav__item">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" />
            </svg>
            <span>{{ __('Account') }}</span>
        </a>
    @endif

    {{-- 5. Concierge --}}
    <a
        href="{{ $isHome ? '#concierge' : url('contact') }}"
        @if($isHome) data-wb-scroll="concierge" @endif
        data-wb-tab="concierge"
        class="wb-bottom-nav__item"
    >
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
        </svg>
        <span>{{ __('Concierge') }}</span>
    </a>
</nav>
