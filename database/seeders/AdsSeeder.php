<?php

namespace Database\Seeders;

use Botble\Ads\Models\Ads;
use Botble\Base\Facades\MetaBox;
use Botble\Base\Supports\BaseSeeder;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AdsSeeder extends BaseSeeder
{
    public function run(): void
    {
        Ads::query()->truncate();

        $items = [
            [
                'name' => 'New Modern & Stylist <br> Crafts',
                'key' => 'IYHICPADQD5X',
            ],
            [
                'name' => 'Popular Energy with our <br> newest collection',
                'key' => 'R4YAV9FECJUS',
            ],
            [
                'name' => 'Winter <br> Exclusive In',
                'key' => 'QPTCBJBOJOSY',
                'image' => 'banners/banner-offer-01.jpg',
                'subtitle' => 'Collection',
            ],
            [
                'name' => '50% Offer',
                'key' => 'T2VFLDYYIJEH',
                'image' => 'banners/banner-offer-02.jpg',
                'subtitle' => 'New Modern Stylist Fashionable <br> Women\'s Wear holder',
            ],
            [
                'name' => 'New Modern & Stylist <br> Crafts',
                'key' => 'JO7LLJHFH1RO',
                'image' => 'banners/banner-03-01.jpg',
                'subtitle' => 'Furniture',
            ],
            [
                'name' => 'Lamp <br> Collections',
                'key' => 'L8GDJUBVD2TQ',
                'image' => 'banners/banner-03-02.jpg',
                'subtitle' => '100 Added',
            ],
            [
                'name' => 'Minimal Chair',
                'key' => 'PXJPAXLOCVRS',
                'image' => 'banners/banner-03-03.jpg',
                'subtitle' => '-60% Offer',
            ],
            [
                'name' => '100% Fresh Product <br> Every Hour',
                'key' => 'EMRCINED6AX9',
                'image' => 'sliders/slider-05-banner-1.jpg',
                'subtitle' => 'Best Bakery Products',
            ],
            [
                'name' => '100% Fresh Product <br> Every Hour',
                'key' => 'JVMDAIB9HO2I',
                'image' => 'sliders/slider-05-banner-1.jpg',
                'subtitle' => 'Best Bakery Products',
            ],
        ];

        foreach ($items as $index => $item) {
            $ads = Ads::query()->create(array_merge(Arr::except($item, 'subtitle'), [
                'order' => $index + 1,
                'key' => $item['key'] ?? strtoupper(Str::random(12)),
                'expired_at' => Carbon::now()->addYears(rand(1, 5)),
                'url' => $item['url'] ?? '/products',
                'image' => $item['image'] ?? 'sliders/banner-slider-0' . ($index + 1) . '.jpg',
            ]));

            if (Arr::has($item, 'subtitle')) {
                MetaBox::saveMetaBoxData($ads, 'subtitle', Arr::get($item, 'subtitle'));
            }
        }
    }
}
