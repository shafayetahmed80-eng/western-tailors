<?php

use Botble\Base\Facades\BaseHelper;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Facades\ProductCategoryHelper;
use Botble\Shortcode\View\View;
use Botble\Theme\Theme;
use Illuminate\View\View as IlluminateView;

return [
    'inherit' => null,

    'events' => [
        'beforeRenderTheme' => function (Theme $theme): void {
            $categories = collect();
            $currencies = collect();

            if (is_plugin_active('ecommerce')) {
                $categories = ProductCategoryHelper::getProductCategoriesWithUrl();

                $currencies = get_all_currencies();
            }

            $theme->partialComposer(['navbar', 'categories-dropdown'], function (IlluminateView $view) use ($categories): void {
                $view->with('categories', $categories);
            });

            $theme->partialComposer('currency-switcher', function (IlluminateView $view) use ($currencies): void {
                $view->with('currencies', $currencies);
            });

            $version = get_cms_version();

            if (BaseHelper::isRtlEnabled()) {
                $theme->asset()->usePath()->add('bootstrap-css', 'plugins/bootstrap/bootstrap.rtl.min.css');
            } else {
                $theme->asset()->usePath()->add('bootstrap-css', 'plugins/bootstrap/bootstrap.min.css');
            }

            $theme->asset()->usePath()->add('animate-css', 'plugins/animate/animate.css');
            $theme->asset()->usePath()->add('swiper-css', 'plugins/swiper/swiper-bundle.css');
            $theme->asset()->usePath()->add('slick-css', 'plugins/slick/slick.css');
            $theme->asset()->usePath()->add('nice-select-css', 'plugins/nice-select/nice-select.css');
            $theme->asset()->usePath()->add('fontawesome-css', 'css/fontawesome.min.css');
            $theme->asset()->usePath()->add('magnific-popup-css', 'plugins/magnific-popup/magnific-popup.css');
            $theme->asset()->usePath()->add('jquery-ui-css', 'plugins/jquery-ui/jquery-ui.css');
            $theme->asset()->usePath()->add('theme-css', 'css/theme.css', version: $version);

            $theme->asset()->container('footer')->usePath()->add('jquery', 'plugins/jquery/jquery-3.7.1.min.js');
            $theme->asset()->container('footer')->usePath()->add('waypoints-js', 'js/waypoints.js');
            $theme->asset()->container('footer')->usePath()->add('bootstrap-js', 'plugins/bootstrap/bootstrap.bundle.min.js');
            $theme->asset()->container('footer')->usePath()->add('swiper-bundle-js', 'plugins/swiper/swiper-bundle.js');
            $theme->asset()->container('footer')->usePath()->add('slick-js', 'plugins/slick/slick.js');
            $theme->asset()->container('footer')->usePath()->add('magnific-popup-js', 'plugins/magnific-popup/magnific-popup.js');
            $theme->asset()->container('footer')->usePath()->add('nice-select-js', 'plugins/nice-select/nice-select.js');
            $theme->asset()->container('footer')->usePath()->add('wow-js', 'js/wow.js');
            $theme->asset()->container('footer')->usePath()->add('isotope-pkgd-js', 'js/isotope-pkgd.js');
            $theme->asset()->container('footer')->usePath()->add('imagesloaded-pkgd-js', 'js/imagesloaded-pkgd.js');
            $theme->asset()->container('footer')->usePath()->add('jquery-ui-js', 'plugins/jquery-ui/jquery-ui.js');
            $theme->asset()->container('footer')->usePath()->add('countdown-js', 'js/countdown.js');
            $theme->asset()->container('footer')->usePath()->add('app-js', 'js/app.js', version: $version);
            $theme->asset()->container('footer')->usePath()->add('theme-js', 'js/theme.js', ['countdown-js'], version: $version);
            $theme->asset()->container('footer')->usePath()->add('ecommerce-js', 'js/ecommerce.js', ['lightgallery-js'], version: $version);

            if (function_exists('shortcode')) {
                $theme->composer([
                    'page',
                    'post',
                    'ecommerce.product',
                    'ecommerce.products',
                    'ecommerce.product-category',
                    'ecommerce.product-tag',
                    'ecommerce.brand',
                    'ecommerce.search',
                    'ecommerce.cart',
                ], function (View $view): void {
                    $view->withShortcodes();
                });
            }

            if (is_plugin_active('ecommerce')) {
                EcommerceHelper::registerThemeAssets();
            }
        },
    ],
];
