<!doctype html>
<html {!! Theme::htmlAttributes() !!}>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $primaryFont = theme_option('primary_font', 'Montserrat');
            $headingFont = theme_option('heading_font', 'Cormorant Garamond');
            $fontUrl = sprintf(
                'https://fonts.googleapis.com/css2?family=%s:wght@300;400;500;600;700&family=%s:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&display=swap',
                urlencode($primaryFont),
                urlencode($headingFont)
            );
            $primaryColor = theme_option('primary_color', '#0B1C18');
            $accentGold = theme_option('accent_gold_color', '#C6A364');
            $rawWa = theme_option('whatsapp_number') ?: theme_option('hotline', '8801700000000');
            $cleanWa = preg_replace('/[^0-9]/', '', $rawWa) ?: '8801700000000';
            $isHomepageView = request()->is('/') || request()->routeIs('public.index');
        @endphp
        {!! BaseHelper::googleFonts($fontUrl) !!}

        <style>
            :root {
                --primary-color: {{ $primaryColor }};
                --primary-color-rgb: {{ implode(',', BaseHelper::hexToRgb($primaryColor)) }};
                --primary-font: '{{ $primaryFont }}', system-ui, -apple-system, sans-serif;
                --heading-font: '{{ $headingFont }}', Georgia, 'Times New Roman', serif;
                --accent-gold: {{ $accentGold }};
                --accent-gold-rgb: {{ implode(',', BaseHelper::hexToRgb($accentGold)) }};
                --wb-emerald-deep: #0B1C18;
                --wb-emerald-night: #06110E;
                --wb-travertine: #F2EFE9;
                --wb-ivory: #FAF8F5;
                --wb-brass: #C6A364;
                --wb-brass-light: #D8B779;
                --wb-charcoal: #161A18;
                --wb-olive: #5C635F;
                --luxury-charcoal: #161A18;
                --header-background-color: {{ theme_option('header_background_color', '#0B1C18') }};
                --header-text-color: {{ theme_option('header_text_color', '#F2EFE9') }};
                --header-menu-text-color: {{ theme_option('header_menu_text_color', '#F2EFE9') }};
                --header-menu-text-hover-color: {{ theme_option('header_menu_text_hover_color', '#C6A364') }};
            }

            /* Luxury Editorial Typographic Hierarchy */
            body {
                font-family: var(--primary-font);
                color: var(--wb-charcoal);
                background-color: var(--wb-travertine);
                -webkit-font-smoothing: antialiased;
            }

            h1, h2, h3, h4, h5, h6,
            .tp-section-title,
            .tpsection__title,
            .tpslider__title,
            .breadcrumb__title,
            .footer-widget-title,
            .footer-cta__contact-title,
            .luxury-serif,
            .wb-serif {
                font-family: var(--heading-font);
                letter-spacing: -0.01em;
            }

            .tp-section-title,
            .tpsection__title {
                font-weight: 500;
                color: var(--wb-charcoal);
            }

            .tpproduct__title,
            .tp-product-title,
            .tpproduct__title a {
                font-family: var(--heading-font);
                font-size: 1.15rem;
                letter-spacing: -0.005em;
                font-weight: 500;
            }

            .tpproduct__price span,
            .product-price {
                font-family: var(--primary-font);
                font-weight: 600;
                color: var(--wb-emerald-deep);
            }

            /* Luxury Button & Interaction Refinement */
            .tp-btn, .tp-btn-2, .tp-btn-square {
                background-color: var(--wb-emerald-deep);
                color: var(--wb-travertine);
                letter-spacing: 0.14em;
                text-transform: uppercase;
                font-size: 0.75rem;
                font-weight: 600;
                border-radius: 10px;
                transition: all 0.25s ease;
            }
            .tp-btn:hover, .tp-btn-2:hover, .tp-btn-square:hover {
                background-color: var(--wb-brass);
                color: var(--wb-emerald-night);
            }

            .btn-bespoke-gold {
                background: var(--wb-brass);
                color: var(--wb-emerald-night) !important;
                border: 1px solid var(--wb-brass);
                font-weight: 600;
                letter-spacing: 0.16em;
                text-transform: uppercase;
                font-size: 0.72rem;
                padding: 12px 24px;
                display: inline-block;
                border-radius: 10px;
                transition: all 0.25s ease;
            }
            .btn-bespoke-gold:hover {
                background: var(--wb-brass-light);
                color: var(--wb-emerald-night) !important;
                border-color: var(--wb-brass-light);
            }

            /* Luxury Badge */
            .badge-bespoke {
                background: var(--wb-brass);
                color: var(--wb-emerald-night);
                font-size: 0.65rem;
                font-weight: 600;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                padding: 4px 10px;
                border-radius: 999px;
            }

            /* Scroll-to-top layout harmony with Mobile Navigation & WhatsApp Concierge */
            .scroll-top.open {
                bottom: 96px !important;
                inset-inline-end: 32px !important;
                background: var(--wb-emerald-deep) !important;
                color: var(--wb-brass) !important;
                border: 1px solid rgba(198, 163, 100, 0.45) !important;
            }
            @media (max-width: 768px) {
                .scroll-top.open {
                    bottom: 82px !important;
                    inset-inline-end: 18px !important;
                }
            }
        </style>

        {!! Theme::header() !!}
    </head>
    <body {!! Theme::bodyAttributes() !!}>
        {!! apply_filters(THEME_FRONT_BODY, null) !!}

        {!! Theme::partial('scroll-top') !!}

        @yield('content')

        @include(Theme::getThemeNamespace('partials.atelier-fitting-modal'))
        @include(Theme::getThemeNamespace('partials.atelier-film-modal'))
        @include(Theme::getThemeNamespace('partials.atelier-quickview-sheet'))

        @include(Theme::getThemeNamespace('partials.whatsapp-concierge'))

        @if(is_plugin_active('ecommerce') && theme_option('bottom_mobile_menu_enabled', 'yes') === 'yes')
            @include(Theme::getThemeNamespace('partials.navigation-bar'))
        @endif

        <div id="wb-toast" class="wb-toast" role="status" aria-live="polite" hidden>
            <span class="wb-toast__dot"></span>
            <span id="wb-toast-text">Added to Atelier Bag</span>
        </div>

        <script>
            'use strict';

            window.trans = {};
            window.siteConfig = {};
            window.atelierConfig = {
                csrfToken: '{{ csrf_token() }}',
                fittingUrl: '{{ route('public.ajax.atelier-fitting') }}',
                newsletterUrl: '{{ route('public.ajax.atelier-newsletter') }}',
                whatsappPhone: '{{ $cleanWa }}',
                isHomepage: {{ $isHomepageView ? 'true' : 'false' }},
                homeUrl: '{{ BaseHelper::getHomepageUrl() }}',
                productsUrl: '{{ is_plugin_active('ecommerce') ? route('public.products') : url('products') }}'
            };
            @if (is_plugin_active('ecommerce'))
                window.currencies = @json(get_currencies_json());
                @if(EcommerceHelper::isCartEnabled())
                    siteConfig.ajaxCart = '{{ route('public.ajax.cart') }}';
                    siteConfig.cartUrl = '{{ route('public.cart') }}';
                @endif
            @endif
        </script>

        {!! Theme::footer() !!}

        @if (is_plugin_active('ecommerce'))
            @include('plugins/ecommerce::themes.includes.gtm-script')
        @endif
    </body>
</html>
