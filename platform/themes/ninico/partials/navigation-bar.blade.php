@php
    $rawPhone = theme_option('whatsapp_number') ?: theme_option('hotline', '8801700000000');
    $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
    if (empty($cleanPhone)) {
        $cleanPhone = '8801700000000';
    }

    $isHome = request()->is('/') || request()->routeIs('public.index');
    $isCatalog = request()->is('products*') || request()->is('product-categories*') || request()->is('product-collections*');
    $isFitting = request()->is('contact*') && request('service') === 'fitting';
@endphp

<nav class="navigation-bar bespoke-mobile-nav" aria-label="{{ __('Mobile Navigation') }}">
    <ul class="bespoke-nav-list mb-0">
        {{-- 1. Home --}}
        <li class="bespoke-nav-item {{ $isHome ? 'active' : '' }}">
            <a href="{{ BaseHelper::getHomepageUrl() }}" title="{{ __('Home') }}">
                <i class="fal fa-home"></i>
                <span>{{ __('Home') }}</span>
            </a>
        </li>

        {{-- 2. Collections / Suits --}}
        <li class="bespoke-nav-item {{ $isCatalog ? 'active' : '' }}">
            <a href="{{ url('products') }}" title="{{ __('Collections') }}">
                <i class="fal fa-layer-group"></i>
                <span>{{ __('Collections') }}</span>
            </a>
        </li>

        {{-- 3. Center Hero: Book Atelier Fitting --}}
        <li class="bespoke-nav-item bespoke-nav-center {{ $isFitting ? 'active' : '' }}">
            <a href="{{ url('contact') }}?service=fitting" title="{{ __('Book Fitting') }}">
                <div class="bespoke-center-circle">
                    <i class="fal fa-calendar-check"></i>
                </div>
                <span class="bespoke-center-label">{{ __('Fitting') }}</span>
            </a>
        </li>

        {{-- 4. WhatsApp Concierge --}}
        <li class="bespoke-nav-item">
            <a
                href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('Hello Western Bespoke Atelier, I would like to inquire about custom tailoring and consultation.') }}"
                target="_blank"
                rel="noopener noreferrer"
                title="{{ __('Master Tailor WhatsApp') }}"
            >
                <i class="fab fa-whatsapp bespoke-nav-wa-icon"></i>
                <span>{{ __('Concierge') }}</span>
            </a>
        </li>

        {{-- 5. Bag (Cart Drawer) --}}
        @if (EcommerceHelper::isCartEnabled())
            <li class="bespoke-nav-item">
                <a role="button" href="javascript:void(0)" class="tp-cart-toggle" title="{{ __('Shopping Bag') }}">
                    <div class="header-cart p-relative d-inline-block">
                        <i class="fal fa-shopping-bag"></i>
                        <span class="tp-product-count bespoke-cart-badge">{{ Cart::instance('cart')->count() }}</span>
                    </div>
                    <span>{{ __('Bag') }}</span>
                </a>
            </li>
        @else
            <li class="bespoke-nav-item">
                <a href="{{ route('customer.overview') }}" title="{{ __('Account') }}">
                    <i class="fal fa-user"></i>
                    <span>{{ __('Account') }}</span>
                </a>
            </li>
        @endif
    </ul>
</nav>

<style>
    /* Sartorial Luxury Mobile Bottom Navigation Bar */
    .bespoke-mobile-nav {
        display: none;
    }

    @media screen and (max-width: 768px) {
        body {
            padding-bottom: calc(62px + env(safe-area-inset-bottom, 0px)) !important;
        }

        .navigation-bar.bespoke-mobile-nav {
            display: block !important;
            position: fixed !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            height: auto !important;
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border-top: 1px solid rgba(197, 168, 128, 0.35) !important;
            box-shadow: 0 -4px 20px rgba(10, 25, 47, 0.08) !important;
            z-index: 1020 !important;
            padding: 4px 6px calc(4px + env(safe-area-inset-bottom, 0px)) !important;
        }

        .bespoke-nav-list {
            display: flex !important;
            align-items: flex-end !important;
            justify-content: space-around !important;
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .bespoke-nav-item {
            flex: 1 1 0 !important;
            max-width: 20% !important;
            text-align: center !important;
            position: relative !important;
            padding: 2px 0 !important;
        }

        .bespoke-nav-item a {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            color: #4A5568 !important;
            padding: 4px 2px !important;
            transition: all 0.2s ease !important;
        }

        .bespoke-nav-item a i {
            display: block !important;
            font-size: 19px !important;
            line-height: 1.2 !important;
            margin-bottom: 3px !important;
            color: #4A5568 !important;
            transition: color 0.2s ease, transform 0.2s ease !important;
        }

        .bespoke-nav-item a span {
            display: block !important;
            font-size: 10px !important;
            font-weight: 500 !important;
            letter-spacing: 0.03em !important;
            font-family: var(--primary-font, 'Jost', sans-serif) !important;
            color: #4A5568 !important;
            white-space: nowrap !important;
            line-height: 1.1 !important;
            transition: color 0.2s ease !important;
        }

        /* Active Tab Styling */
        .bespoke-nav-item.active a i,
        .bespoke-nav-item a:hover i {
            color: #0A192F !important;
            transform: translateY(-1px) !important;
        }

        .bespoke-nav-item.active a span,
        .bespoke-nav-item a:hover span {
            color: #0A192F !important;
            font-weight: 700 !important;
        }

        .bespoke-nav-item.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #C5A880;
        }

        /* Center Hero Button (Book Fitting) */
        .bespoke-nav-center {
            position: relative !important;
            top: -12px !important;
        }

        .bespoke-center-circle {
            width: 46px !important;
            height: 46px !important;
            border-radius: 50% !important;
            background: linear-gradient(135deg, #C5A880 0%, #D4AF37 100%) !important;
            border: 3px solid #ffffff !important;
            box-shadow: 0 4px 14px rgba(197, 168, 128, 0.5), 0 2px 6px rgba(10, 25, 47, 0.15) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 auto 3px !important;
            transition: transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
        }

        .bespoke-nav-center a:hover .bespoke-center-circle,
        .bespoke-nav-center.active .bespoke-center-circle {
            transform: scale(1.08) translateY(-2px) !important;
            box-shadow: 0 6px 18px rgba(197, 168, 128, 0.65), 0 3px 8px rgba(10, 25, 47, 0.2) !important;
        }

        .bespoke-center-circle i {
            font-size: 20px !important;
            color: #0A192F !important;
            margin-bottom: 0 !important;
            line-height: 1 !important;
        }

        .bespoke-center-label {
            font-size: 9.5px !important;
            font-weight: 700 !important;
            color: #0A192F !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
        }

        /* WhatsApp Tab */
        .bespoke-nav-wa-icon {
            color: #25D366 !important;
        }

        .bespoke-nav-item a:hover .bespoke-nav-wa-icon {
            color: #1EBE5D !important;
        }

        /* Cart Badge */
        .header-cart.p-relative {
            position: relative;
            display: inline-block;
        }

        .bespoke-cart-badge {
            position: absolute !important;
            top: -6px !important;
            inset-inline-end: -10px !important;
            background: #0A192F !important;
            color: #C5A880 !important;
            border: 1px solid #C5A880 !important;
            border-radius: 10px !important;
            font-size: 9px !important;
            font-weight: 700 !important;
            padding: 1px 4px !important;
            min-width: 15px !important;
            height: 15px !important;
            line-height: 13px !important;
            text-align: center !important;
        }
    }
</style>
