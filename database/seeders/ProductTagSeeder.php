<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\ProductTag;
use Botble\Slug\Facades\SlugHelper;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Str;

class ProductTagSeeder extends BaseSeeder
{
    public function run(): void
    {
        ProductTag::query()->truncate();

        $tags = [
            'Electronic',
            'Mobile',
            'Iphone',
            'Printer',
            'Office',
            'IT',
        ];

        foreach ($tags as $item) {
            $tag = ProductTag::query()->create([
                'name' => $item,
            ]);

            Slug::query()->create([
                'reference_type' => ProductTag::class,
                'reference_id' => $tag->id,
                'key' => Str::slug($tag->name),
                'prefix' => SlugHelper::getPrefix(ProductTag::class),
            ]);
        }
    }
}
