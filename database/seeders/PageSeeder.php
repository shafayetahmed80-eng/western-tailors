<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Page\Database\Traits\HasPageSeeder;

class PageSeeder extends BaseSeeder
{
    use HasPageSeeder;

    public function run(): void
    {
        $this->uploadFiles('shop');

        $pages = [
            [
                'name' => 'Wooden Home',
                'content' => '[simple-slider key="slider-home-1" style="wooden" ads_1="IYHICPADQD5X" ads_2="R4YAV9FECJUS"][/simple-slider]' .
                    htmlentities(
                        '[product-categories title="Top <span>Categories</span>" category_ids="10,11,12,13,14,15" style="wooden" enable_lazy_loading="yes"][/product-categories]'
                    ) .
                    htmlentities(
                        '[products style="wooden" title="Popular <span>Products</span>" limit="10" enable_lazy_loading="yes"][/products]'
                    ) .
                    '[deal-product flash_sale_id="1" style="wooden" enable_lazy_loading="yes"][/deal-product]' .
                    '[gallery title="ninico-shop" limit="6" subtitle="Follow On" enable_lazy_loading="yes"][/gallery]',
                'template' => 'full-width',
                'metadata' => [
                    'header_style' => 'collapsed',
                ],
            ],
            [
                'name' => 'Fashion Home',
                'content' => '[simple-slider key="slider-home-2" style="fashion"][/simple-slider]' .
                    htmlentities(
                        '[product-categories title="Top <span>Categories</span>" category_ids="1,2,3,4" style="fashion" enable_lazy_loading="yes"][/product-categories]'
                    ) .
                    htmlentities(
                        '[products style="fashion" title="Popular <span>Products</span>" limit="10" enable_lazy_loading="yes"][/products]'
                    ) .
                    '[theme-ads key_1="QPTCBJBOJOSY" key_2="T2VFLDYYIJEH" enable_lazy_loading="yes"][/theme-ads]' .
                    '[featured-posts title="Popular Posts" limit="4" enable_lazy_loading="yes"][/featured-posts]' .
                    '[brands title="Happy Sponsors" quantity="6" name_1="Bustle" image_1="brands/brand-01.png" link_1="#" name_2="Bazaar" image_2="brands/brand-02.png" link_2="#" name_3="goop" image_3="brands/brand-03.png" link_3="#" name_4="Brit + Co" image_4="brands/brand-04.png" link_4="#" name_5="The Coveteur" image_5="brands/brand-05.png" link_5="#" name_6="allure" image_6="brands/brand-06.png" link_6="#" enable_lazy_loading="yes"][/brands]',
                'template' => 'full-width',
                'metadata' => [
                    'customize_footer' => 'custom',
                    'footer_background_color' => '#040404',
                    'footer_text_color' => '#fff',
                    'footer_text_muted_color' => '#a0a0a0',
                    'footer_logo' => 'general/logo-white.png',
                    'footer_border_color' => '#282828',
                    'footer_bottom_background_color' => '#040404',
                ],
            ],
            [
                'name' => 'Furniture Home',
                'content' => '[simple-slider key="slider-furniture" style="furniture"][/simple-slider]' .
                    '[services quantity="4" title_1="Free shipping" description_1="Free shipping on orders over." image_1="icons/box.png" title_2="Free Returns" description_2="30-days free return policy" image_2="icons/car.png" title_3="Secured Payments" description_3="We accept all major credit cards" image_3="icons/payment.png" title_4="Customer Service" description_4="Top notch customer service" image_4="icons/hours.png" enable_lazy_loading="yes"][/services]' .
                    htmlentities(
                        '[products style="wooden" title="Popular <span>Products</span>" limit="10" enable_lazy_loading="yes"][/products]'
                    ) .
                    '[theme-ads style="furniture" key_1="JO7LLJHFH1RO" key_2="L8GDJUBVD2TQ" key_3="PXJPAXLOCVRS" enable_lazy_loading="yes"][/theme-ads]' .
                    '[deal-product flash_sale_id="1" enable_lazy_loading="yes"][/deal-product]' .
                    '[products-slide title="Top Sell In Month" limit="5" type="trending" enable_lazy_loading="yes"][/products-slide]' .
                    '[brands title="Happy Sponsors" background_color="#040404" quantity="6" name_1="Bustle" image_1="brands/brand-w-01.png" link_1="https://www.bustle.com" name_2="Bazaar" image_2="brands/brand-w-02.png" link_2="https://www.harpersbazaar.com" name_3="Goop" image_3="brands/brand-w-03.png" link_3="https://goop.com/" name_4="Brit + Co" image_4="brands/brand-w-04.png" link_4="https://www.brit.co" name_5="The Couture Club" image_5="brands/brand-w-05.png" link_5="https://www.thecoutureclub.com" name_6="Allure" image_6="brands/brand-w-06.png" link_6="https://www.allure.com" enable_lazy_loading="yes"][/brands]' .
                    '[featured-posts title="Blog & Insights" limit="4" type="popular" url="/blog" enable_lazy_loading="yes"][/featured-posts]',
                'template' => 'full-width',
                'metadata' => [
                    'customize_footer' => 'custom',
                    'footer_bottom_background_color' => '#f8f8f8',
                ],
            ],
            [
                'name' => 'Cosmetics Home',
                'content' => '[simple-slider key="slider-cosmetics" style="cosmetics"][/simple-slider]' .
                    '[brands background_color="#F7EFEC" quantity="6" name_1="Bustle" image_1="brands/pla-brand-01.png" link_1="https://www.bustle.com" name_2="Bazaar" image_2="brands/pla-brand-02.png" link_2="https://www.harpersbazaar.com" name_3="Goop" image_3="brands/pla-brand-03.png" link_3="https://goop.com/" name_4="Brit + Co" image_4="brands/pla-brand-04.png" link_4="https://www.brit.co" name_5="The Couture Club" image_5="brands/pla-brand-05.png" link_5="https://www.thecoutureclub.com" name_6="Allure" image_6="brands/pla-brand-06.png" link_6="https://www.allure.com" enable_lazy_loading="yes"][/brands]' .
                    '[product-collections collection_ids="4,5,6,7" enable_lazy_loading="yes"][/product-collections]' .
                    htmlentities(
                        '[products style="wooden" title="Popular <span>Products</span>" limit="4" enable_lazy_loading="yes"][/products]'
                    ) .
                    '[product-categories category_ids="10,11,12,13,14,15" style="cosmetics" enable_lazy_loading="yes"][/product-categories]' .
                    '[deal-product flash_sale_id="1" style="cosmetics" marque_text="Great Deal Of The Day Shop Now" marque_highlight_text="Shop Now" marque_highlight_url="/products" highlight_background="blog/9.jpg" enable_lazy_loading="yes"][/deal-product]' .
                    '[testimonials title="User Feedbacks" limit="3" enable_lazy_loading="yes"][/testimonials]' .
                    '[featured-posts title="Blog & Insights" limit="4" type="popular" url="/blog" enable_lazy_loading="yes"][/featured-posts]',
                'template' => 'full-width',
                'metadata' => [
                    'header_style' => 'centered-logo',
                    'customize_footer' => 'custom',
                    'footer_background_color' => '#F7EFEC',
                    'footer_bottom_background_color' => '#F7EFEC',
                ],
            ],
            [
                'name' => 'Food Grocery Home',
                'content' => '[simple-slider key="slider-grocery" style="grocery" ads_1="EMRCINED6AX9" ads_2="JVMDAIB9HO2I" background_image="banners/banner-bg-05.jpg"][/simple-slider]' .
                    '[services quantity="4" title_1="Free shipping" description_1="Free shipping on orders over." image_1="icons/box.png" title_2="Free Returns" description_2="30-days free return policy" image_2="icons/car.png" title_3="Secured Payments" description_3="We accept all major credit cards" image_3="icons/payment.png" title_4="Customer Service" description_4="Top notch customer service" image_4="icons/hours.png" enable_lazy_loading="yes"][/services]' .
                    htmlentities(
                        '[products style="wooden" title="Popular <span>Products</span>" limit="10" enable_lazy_loading="yes"][/products]'
                    ) .
                    '[deal-product flash_sale_id="1" style="cosmetics" enable_lazy_loading="yes"][/deal-product]' .
                    '[products-by-categories category_ids="2,3,6,11" number_of_products="4" enable_lazy_loading="yes"][/products-by-categories]' .
                    '[testimonials title="User Feedbacks" limit="3" background_color="#F7EFEC" card_color="#FFFFFF" enable_lazy_loading="yes"][/testimonials]' .
                    '[featured-posts title="Blog & Insights" limit="4" url="/blog" enable_lazy_loading="yes"][/featured-posts]',
                'template' => 'full-width',
                'metadata' => [
                    'customize_footer' => 'custom',
                    'footer_background_color' => '#F7EFEC',
                    'footer_bottom_background_color' => '#F7EFEC',
                ],
            ],
            [
                'name' => 'Blog',
            ],
            [
                'name' => 'About',
                'content' => '[about image_1="banners/about-img-1.jpg" image_2="banners/about-img-2.jpg" logo="banners/about-img-3.png" title="About Our Story" subtitle="About Us" story_text_1="Publish your eCommerce site quickly with our easy-to-use store builder— no coding required. Migrate your items from your point of sale system or turn your Instagram feed into a shopping site and start selling fast. Square Online works for all kinds of businesses—retail, restaurants, services without costly customization or add ons. Get orders to your customers in lots of ways by offering shipping, pickup, delivery, and even QR code ordering." story_text_2="Expand your reach and sell more using seamless integrations with Google, Instagram, Facebook, and more. Built- in SEO tools make it easy for shoppers to find your business on search engines. Get access to the entire suite of integrated Square solutions to help you run your business. Integration between Square Online and all Square point of sale systems makes inventory management easy. Subscribe to Square Marketing and easily send email promotions to your customers using the contact information." list_item_1="Orders go right to your restaurant point of sale, KDS, and kitchen" list_item_url_1="#" list_item_2="Provide in-person pickup, & delivery by professional couriers" list_item_url_2="#" list_item_3="Offer in-person diners self-serve, contactless ordering via QR codes." list_item_url_3="#" enable_lazy_loading="yes"][/about]' .
                    '[team title="Meet With Team" subtitle="Team" team_ids="1,2,3,4"][/team]' .
                    '[features quantity="2" title_1="Solutions that work together" subtitle_1="Features #01" description_1="Publish your eCommerce site quickly with our easy-to-use store builder— no coding required. Migrate your items from your point of sale system or turn your Instagram feed into a shopping site and start selling fast. Square Online works for all kinds of businesses—retail, restaurants, services." image_1="banners/about-banner-1.jpg" button_label_1="Get In Touch" button_url_1="#" title_2="All kinds of payments securely" subtitle_2="Features #02" description_2="Publish your eCommerce site quickly with our easy-to-use store builder— no coding required. Migrate your items from your point of sale system or turn your Instagram feed into a shopping site and start selling fast. Square Online works for all kinds of businesses—retail, restaurants, services." image_2="banners/about-banner-2.jpg" button_label_2="Contact With Us" button_url_2="#" enable_lazy_loading="yes"][/features]',
                'template' => 'default',
                'metadata' => [
                    'customize_footer' => 'custom',
                    'footer_background_color' => '#040404',
                    'footer_text_color' => '#fff',
                    'footer_text_muted_color' => '#a0a0a0',
                    'footer_logo' => 'general/logo-white.png',
                    'footer_border_color' => '#282828',
                    'footer_bottom_background_color' => '#040404',
                ],
            ],
            [
                'name' => 'Contact',
                'content' => '[contact-box title="Get In Touch" address="24/26 Strait Bargate, Boston, PE21, United Kingdom" phone=" +098 (905) 786 897 8" email="ninico@example.com" hours="10 am - 10 pm EST, 7 days a week" show_contact_form="1" button_label_1="Get Support On Call" button_url_1="#" button_icon_1="fa fa-headphones-alt" button_label_2="Get Direction" button_url_2="#" button_icon_2="fa fa-map-marker-alt"][/contact-box]' .
                    '[google-map]24/26 Strait Bargate, Boston, PE21, United Kingdom[/google-map]',
            ],
            [
                'name' => 'Coming soon',
                'content' => '[coming-soon title="We are Coming Soon" subtitle="Coming Soon!" time="2025-10-24" background_image="banners/coming-soon.jpg" logo_style="general/logo-white.png" show_subscribe_form="1"][/coming-soon]',
                'template' => 'blank',
            ],
            [
                'name' => 'Store Locator',
                'content' => '[shop-location quantity="4" name_1="Baldwin Hills Crenshaw Plaza" address_1="24/26 Strait Bargate, Boston, PE21, United Kingdom" phone_1="+098 (905) 786 897 8" hours_1="10 am - 10 pm EST, 7 days a week" image_1="shop/location-1.png" name_2="Ninico Hills Crenshaw Plaza" address_2=" 36/26 Strait Bargate, Boston, PE21, United Kingdom" phone_2="+098 112 786 897 8" hours_2="9 am - 10 pm EST, 5 days a week" image_2="shop/location-2.png" name_3="Vegas BGM Crenshaw Plaza" address_3="40/26 Strait Bargate, Vegas, PE21, United Kingdom" phone_3=" +098 (905) 786 897 8" hours_3="10 am - 10 pm EST, 7 days a week" image_3="shop/location-3.png" name_4="Bargate Cine Crenshaw Plaza" address_4="38/26 Strait Bargate, Point, PE21, United Kingdom" phone_4="6 - 146 - 389 - 5748" hours_4="10 am - 10 pm EST, 7 days a week" image_4="shop/location-4.png" enable_lazy_loading="yes"][/shop-location]' .
                    '[google-map]New York, USA[/google-map]',
            ],
            [
                'name' => 'FAQs',
                'content' => '[faqs category_ids="1,2,3"][/faqs]',
            ],
        ];

        $this->truncatePages();

        $this->createPages($pages);
    }
}
