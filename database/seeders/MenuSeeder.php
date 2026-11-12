<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Blog\Models\Post;
use Botble\Ecommerce\Models\Product;
use Botble\Menu\Database\Traits\HasMenuSeeder;
use Botble\Page\Database\Traits\HasPageSeeder;
use Botble\Page\Models\Page;

class MenuSeeder extends BaseSeeder
{
    use HasMenuSeeder;
    use HasPageSeeder;

    public function run(): void
    {
        $menus = [
            [
                'name' => 'Main menu',
                'location' => 'main-menu',
                'items' => [
                    [
                        'title' => 'Home',
                        'url' => '/',
                        'children' => [
                            [
                                'title' => 'Wooden Home',
                                'reference_type' => Page::class,
                                'reference_id' => 1,
                            ],
                            [
                                'title' => 'Fashion Home',
                                'reference_type' => Page::class,
                                'reference_id' => 2,
                            ],
                            [
                                'title' => 'Furniture Home',
                                'reference_type' => Page::class,
                                'reference_id' => 3,
                            ],
                            [
                                'title' => 'Cosmetics Home',
                                'reference_type' => Page::class,
                                'reference_id' => 4,
                            ],
                            [
                                'title' => 'Food Grocery',
                                'reference_type' => Page::class,
                                'reference_id' => 5,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Shop',
                        'url' => '/',
                        'children' => [
                            [
                                'title' => 'Shop Grid',
                                'url' => '/products',
                            ],
                            [
                                'title' => 'Shop List',
                                'url' => '/products?layout=list',
                            ],
                            [
                                'title' => 'Shop Detail',
                                'url' => Product::query()->inRandomOrder()->first()->url,
                            ],
                            [
                                'title' => 'Shop Location',
                                'reference_type' => Page::class,
                                'reference_id' => 10,
                            ],
                            [
                                'title' => 'Cart',
                                'url' => '/cart',
                            ],
                            [
                                'title' => 'Wishlist',
                                'url' => '/wishlist',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Pages',
                        'url' => '/',
                        'children' => [
                            [
                                'title' => 'Order Tracking',
                                'url' => '/orders/tracking',
                            ],
                            [
                                'title' => 'About',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('About'),
                            ],
                            [
                                'title' => 'Sign up',
                                'url' => '/register',
                            ],
                            [
                                'title' => 'Login',
                                'url' => '/login',
                            ],
                            [
                                'title' => '404 / Error',
                                'url' => '/404',
                            ],
                            [
                                'title' => 'Coming soon',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Coming soon'),
                            ],
                        ],
                    ],
                    [
                        'title' => 'Blog',
                        'url' => '/',
                        'children' => [
                            [
                                'title' => 'Blog',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Blog'),
                            ],
                            [
                                'title' => 'Blog Detail',
                                'url' => Post::query()->first()->url,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Contact',
                        'reference_type' => Page::class,
                        'reference_id' => $this->getPageId('Contact'),
                    ],
                ],
            ],
            [
                'name' => 'Information',
                'location' => 'information',
                'items' => [
                    [
                        'title' => 'Custom Service',
                        'url' => '/',
                    ],
                    [
                        'title' => 'FAQs',
                        'reference_type' => Page::class,
                        'reference_id' => $this->getPageId('FAQs'),
                    ],
                    [
                        'title' => 'Order Tracking',
                        'url' => 'orders/tracking',
                    ],
                    [
                        'title' => 'Contact',
                        'reference_type' => Page::class,
                        'reference_id' => $this->getPageId('Contact'),
                    ],
                    [
                        'title' => 'Events',
                        'url' => '/',
                    ],
                ],
            ],
            [
                'name' => 'My Account',
                'location' => 'my-account',
                'items' => [
                    [
                        'title' => 'Delivery Information',
                        'url' => '/',
                    ],
                    [
                        'title' => 'Privacy Policy',
                        'url' => '/',
                    ],
                    [
                        'title' => 'Discount',
                        'url' => '/',
                    ],
                    [
                        'title' => 'Custom Service',
                        'url' => '/',
                    ],
                    [
                        'title' => 'Terms & Condition',
                        'url' => '/',
                    ],
                ],
            ],
            [
                'name' => 'Social Network',
                'location' => 'social-network',
                'items' => [
                    [
                        'title' => 'Facebook',
                        'icon_font' => 'ti ti-brand-facebook',
                        'url' => 'https://facebook.com',
                    ],
                    [
                        'title' => 'Dribble',
                        'icon_font' => 'ti ti-brand-dribbble',
                        'url' => 'https://dribbble.com',
                    ],
                    [
                        'title' => 'X (Twitter)',
                        'icon_font' => 'ti ti-brand-x',
                        'url' => 'https://x.com',
                    ],
                    [
                        'title' => 'Behance',
                        'icon_font' => 'ti ti-brand-behance',
                        'url' => 'https://behance.com',
                    ],
                    [
                        'title' => 'YouTube',
                        'icon_font' => 'ti ti-brand-youtube',
                        'url' => 'https://youtube.com',
                    ],
                ],
            ],
        ];

        $this->createMenus($menus);
    }
}
