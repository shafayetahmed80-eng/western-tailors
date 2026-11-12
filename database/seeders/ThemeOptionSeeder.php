<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Theme\Database\Traits\HasThemeOptionSeeder;
use Botble\Theme\Supports\ThemeSupport;

class ThemeOptionSeeder extends BaseSeeder
{
    use HasThemeOptionSeeder;

    public function run(): void
    {
        $this->uploadFiles('banners');
        $this->uploadFiles('icons');

        $this->createThemeOptions([
            'site_title' => 'Ninico - Minimal eCommerce',
            'seo_description' => 'Ninico is a modern and flexible Minimal eCommerce Laravel script. This script is suited for electronic, organic and grocery store, furniture store, clothing store, hitech store and accessories store...',
            'favicon' => $this->filePath('general/favicon.png'),
            'logo_light' => $this->filePath('general/logo-white.png'),
            'logo' => $this->filePath('general/logo.png'),
            'primary_font' => 'Jost',
            'primary_color' => '#d51243',
            'hotline' => '908. 408. 501. 89',
            'homepage_id' => 1,
            'blog_page_id' => 6,
            'cart_footer_description' => 'Free shipping for orders <b>under 10km</b>',
            'breadcrumb_background' => $this->filePath('banners/breadcrumb-01.jpg'),
            'login_background' => $this->filePath('banners/login-bg.jpg'),
            'register_background' => $this->filePath('banners/sign-bg.jpg'),
            '404_not_found_icon' => $this->filePath('icons/error.png'),
            'order_tracking_background' => $this->filePath('banners/track-bg.jpg'),
            'default_product_list_layout' => 'grid',
            'number_of_products_per_page' => 30,
            'footer_background_color' => '#F8F8F8',
            'footer_text_color' => '#000000',
            'footer_text_muted_color' => '#686666',
            'footer_border_color' => '#E0E0E0',
            'footer_bottom_background_color' => '#ededed',
            'preloader_version' => 'v2',
            'newsletter_popup_enable' => true,
            'newsletter_popup_image' => $this->filePath('general/newsletter-popup.png'),
            'newsletter_popup_title' => 'Subscribe Now',
            'newsletter_popup_subtitle' => 'Newsletter',
            'newsletter_popup_description' => 'Subscribe to our newsletter and get 10% off your first purchase',
            'social_links' => ThemeSupport::getDefaultSocialLinksData(),
        ]);
    }
}
