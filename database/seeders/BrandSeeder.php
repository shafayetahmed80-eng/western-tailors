<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\Brand;
use Botble\Slug\Facades\SlugHelper;

class BrandSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('brands');

        Brand::query()->truncate();

        $brands = [
            'Fashion live',
            'Hand crafted',
            'Mestonix',
            'Sunshine',
            'Pure',
            'Anfold',
        ];

        foreach ($brands as $key => $item) {
            $brand = Brand::query()->create([
                'name' => $item,
                'order' => $key,
                'is_featured' => rand(0, 1),
                'logo' => 'brands/brand-0' . ($key + 1) . '.png',
            ]);

            SlugHelper::createSlug($brand);
        }
    }
}
