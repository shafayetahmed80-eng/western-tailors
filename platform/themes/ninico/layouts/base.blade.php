<!doctype html>
<html {!! Theme::htmlAttributes() !!}>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $primaryFont = theme_option('primary_font', 'Jost');
            $headingFont = theme_option('heading_font', 'Playfair Display');
            $fontUrl = sprintf(
                'https://fonts.googleapis.com/css2?family=%s:wght@400;500;600;700&family=%s:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap',
                urlencode($primaryFont),
                urlencode($headingFont)
            );
        @endphp
        {!! BaseHelper::googleFonts($fontUrl) !!}

        <style>
            :root {
                --primary-color: {{ $primaryColor = theme_option('primary_color', '#0A192F') }};
                --primary-color-rgb: {{ implode(',', BaseHelper::hexToRgb($primaryColor)) }};
                --primary-font: '{{ $primaryFont }}', sans-serif;
                --heading-font: '{{ $headingFont }}', Georgia, 'Times New Roman', serif;
                --accent-gold: {{ $accentGold = theme_option('accent_gold_color', '#C5A880') }};
                --accent-gold-rgb: {{ implode(',', BaseHelper::hexToRgb($accentGold)) }};
                --luxury-charcoal: #111111;
                --header-background-color: {{ theme_option('header_background_color', '#ffffff') }};
                --header-text-color: {{ theme_option('header_text_color', '#111111') }};
                --header-menu-text-color: {{ theme_option('header_menu_text_color', '#111111') }};
                --header-menu-text-hover-color: {{ theme_option('header_menu_text_hover_color', '#C5A880') }};
            }

            /* Luxury Bespoke Typographic Hierarchy */
            h1, h2, h3, h4, h5, h6,
            .tp-section-title,
            .tpslider__title,
            .breadcrumb__title,
            .footer-widget-title,
            .footer-cta__contact-title,
            .luxury-serif {
                font-family: var(--heading-font);
                letter-spacing: -0.015em;
            }

            .tp-section-title {
                font-weight: 600;
                color: #111111;
            }

            .tpproduct__title,
            .tp-product-title,
            .tpproduct__title a {
                font-family: var(--heading-font);
                font-size: 1.05rem;
                letter-spacing: -0.01em;
                font-weight: 600;
            }

            .tpproduct__price span,
            .product-price {
                font-family: var(--primary-font);
                font-weight: 600;
                color: var(--primary-color);
            }

            /* Luxury Button & Interaction Refinement */
            .tp-btn, .tp-btn-2, .tp-btn-square {
                letter-spacing: 0.06em;
                text-transform: uppercase;
                font-size: 0.8rem;
                font-weight: 600;
                border-radius: 2px;
                transition: all 0.3s ease;
            }

            .btn-bespoke-gold {
                background: linear-gradient(135deg, #C5A880 0%, #D4AF37 100%);
                color: #111111 !important;
                border: 1px solid #C5A880;
                font-weight: 600;
                letter-spacing: 0.05em;
                text-transform: uppercase;
                padding: 10px 22px;
                display: inline-block;
                border-radius: 2px;
            }
            .btn-bespoke-gold:hover {
                background: #111111;
                color: #C5A880 !important;
                border-color: #111111;
            }

            /* Luxury Badge */
            .badge-bespoke {
                background: linear-gradient(135deg, #C5A880 0%, #D4AF37 100%);
                color: #111111;
                font-size: 0.7rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                padding: 3px 8px;
                border-radius: 2px;
            }
        </style>

        {!! Theme::header() !!}
    </head>
    <body {!! Theme::bodyAttributes() !!}>
        {!! apply_filters(THEME_FRONT_BODY, null) !!}

        {!! Theme::partial('scroll-top') !!}

        @yield('content')

        @if(is_plugin_active('ecommerce') && theme_option('bottom_mobile_menu_enabled', 'yes') === 'yes')
            @include(Theme::getThemeNamespace('partials.navigation-bar'))
        @endif

        <script>
            'use strict';

            window.trans = {};
            window.siteConfig = {};
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
