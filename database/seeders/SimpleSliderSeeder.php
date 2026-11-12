<?php

namespace Database\Seeders;

use Botble\Base\Facades\MetaBox;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\SimpleSlider\Models\SimpleSlider;
use Botble\SimpleSlider\Models\SimpleSliderItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SimpleSliderSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('sliders');

        SimpleSlider::query()->truncate();
        SimpleSliderItem::query()->truncate();

        $sliders = [
            [
                'name' => 'Slider home 1',
                'description' => 'The slider on home page 1',
                'items' => [
                    [
                        'title' => 'Up To <i>40% Off</i> latest Creations',
                        'subtitle' => 'Accessories',
                        'description' => 'Accessories',
                        'image' => 'sliders/banner-1.jpg',
                    ],
                    [
                        'title' => 'Up To <i>40% Off</i> latest Creations',
                        'subtitle' => 'Accessories',
                        'description' => 'Accessories',
                        'image' => 'sliders/banner-2.jpg',
                    ],
                    [
                        'title' => 'Up To <i>40% Off</i> latest Creations',
                        'subtitle' => 'Accessories',
                        'description' => 'Accessories',
                        'image' => 'sliders/banner-3.jpg',
                    ],
                ],
            ],
            [
                'name' => 'Slider home 2',
                'description' => 'The slider on home page 2',
                'items' => [
                    [
                        'title' => 'Exclusive <br> Winter Collection',
                        'subtitle' => 'Winter',
                        'description' => 'New Modern Stylist Fashionable Women\'s Wear holder',
                        'image' => 'sliders/slider-01.png',
                    ],
                    [
                        'title' => 'Exclusive <br> Women\'s Fashion',
                        'subtitle' => 'Winter',
                        'description' => 'New Modern Stylist Fashionable Women\'s Wear holder',
                        'image' => 'sliders/slider-02.png',
                    ],
                    [
                        'title' => 'Exclusive <br> Summer Collection',
                        'subtitle' => 'Winter',
                        'description' => 'New Modern Stylist Fashionable Women\'s Wear holder',
                        'image' => 'sliders/slider-03.png',
                    ],
                ],
            ],
            [
                'name' => 'Slider Furniture',
                'description' => 'The slider for furniture style',
                'items' => [
                    [
                        'title' => 'Wooden <br> Lounge Furniture',
                        'description' => "New Modern Stylist Fashionable Women's Wear holder",
                        'image' => 'sliders/slider-04.png',
                    ],
                    [
                        'title' => 'Wooden <br> Lounge Chair',
                        'subtitle' => "New Modern Stylist Fashionable Women's Wear holder",
                        'image' => 'sliders/slider-05.png',
                    ],
                    [
                        'title' => 'Wooden <br> Houston Furniture',
                        'subtitle' => "New Modern Stylist Fashionable Women's Wear holder",
                        'image' => 'sliders/slider-06.png',
                    ],
                ],
            ],
            [
                'name' => 'Slider Cosmetics',
                'description' => 'The slider for cosmetics style',
                'items' => [
                    [
                        'title' => 'Will Never <br> Compromise Beauty',
                        'description' => "New Modern Stylist Fashionable Women's Wear holder",
                        'image' => 'sliders/slider-bg-04.png',
                    ],
                    [
                        'title' => 'Will Never <br> Compromise Glow',
                        'description' => "New Modern Stylist Fashionable Women's Wear holder",
                        'image' => 'sliders/slider-bg-05.png',
                    ],
                    [
                        'title' => 'Will Never <br> Compromise Health',
                        'description' => "New Modern Stylist Fashionable Women's Wear holder",
                        'image' => 'sliders/slider-bg-06.png',
                    ],
                ],
            ],
            [
                'name' => 'Slider Grocery',
                'description' => 'The slider for grocery style',
                'items' => [
                    [
                        'title' => 'Fresh Grocery <br> Products.',
                        'description' => 'Quality & Fresh Products',
                        'image' => 'sliders/slider-05-bg-1.jpg',
                    ],
                    [
                        'title' => 'Fresh Grocery <br> Products.',
                        'description' => 'Quality & Fresh Products',
                        'image' => 'sliders/slider-05-bg-2.jpg',
                    ],
                    [
                        'title' => 'Fresh Grocery <br> Products.',
                        'description' => 'Quality & Fresh Products',
                        'image' => 'sliders/slider-05-bg-3.jpg',
                    ],
                ],
            ],
        ];

        foreach ($sliders as $item) {
            $slider = SimpleSlider::query()->create(array_merge(Arr::except($item, ['items']), [
                'key' => Str::slug($item['name']),
            ]));

            foreach ($item['items'] as $key => $data) {
                $sliderItem = SimpleSliderItem::query()->create(array_merge(Arr::except($data, 'subtitle'), [
                    'link' => '/products',
                    'order' => $key + 1,
                    'simple_slider_id' => $slider->id,
                ]));

                MetaBox::saveMetaBoxData($sliderItem, 'subtitle', Arr::get($data, 'subtitle'));
                MetaBox::saveMetaBoxData($sliderItem, 'action_label', 'Shop Now');
            }

            LanguageMeta::saveMetaData($slider, 'en_US');
        }
    }
}
