<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\ProductCollection;
use Illuminate\Support\Str;

class ProductCollectionSeeder extends BaseSeeder
{
    public function run(): void
    {
        ProductCollection::query()->truncate();

        $collections = [
            [
                'name' => 'New Arrival',
            ],
            [
                'name' => 'Best Sellers',
            ],
            [
                'name' => 'Special Offer',
            ],
            [
                'name' => 'Reactive Providence Hair Color',
                'image' => 'banners/thumb-01.jpg',
            ],
            [
                'name' => 'New Modern & Stylist Makeup',
                'image' => 'banners/thumb-02.jpg',
            ],
            [
                'name' => 'Intensive Glow C+ Serum',
                'image' => 'banners/thumb-03.jpg',
            ],
            [
                'name' => 'Vogue',
                'image' => 'banners/thumb-04.jpg',
            ],
        ];

        foreach ($collections as $collection) {
            ProductCollection::query()->create(array_merge($collection, [
                'slug' => Str::slug($collection['name']),
            ]));
        }
    }
}
