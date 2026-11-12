<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Slug\Facades\SlugHelper;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProductCategorySeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('features');

        ProductCategory::query()->truncate();

        $categories = [
            [
                'name' => 'Pro Glasses',
                'image' => 'banners/banner-2-01.jpg',
            ],
            [
                'name' => 'Casual Shoes',
                'image' => 'banners/banner-2-02.jpg',
                'children' => [
                    [
                        'name' => 'Winter Jacket',
                        'image' => 'banners/banner-2-03.jpg',
                    ],
                    [
                        'name' => 'New Added',
                        'image' => 'banners/banner-2-04.jpg',
                    ],
                    [
                        'name' => 'Wooden',
                    ],
                    [
                        'name' => 'Furniture',
                    ],
                    [
                        'name' => 'Clock',
                    ],
                    [
                        'name' => 'Gifts',
                    ],
                    [
                        'name' => 'Crafts',
                    ],
                ],
            ],
            [
                'name' => 'Gift Sets',
                'image' => 'features/feature-icon-01.png',
            ],
            [
                'name' => 'Plastic Gifts',
                'image' => 'features/feature-icon-02.png',
            ],
            [
                'name' => 'Handy Cream',
                'image' => 'features/feature-icon-03.png',
            ],
            [
                'name' => 'Cosmetics',
                'image' => 'features/feature-icon-04.png',
            ],
            [
                'name' => 'Silk Accessories',
                'image' => 'features/feature-icon-05.png',
            ],
            [
                'name' => 'Finest Skincare Lotions',
                'image' => 'features/feature-icon-06.png',
            ],
            [
                'name' => 'Bags & Purses',
            ],
            [
                'name' => 'Sunglasses',
            ],
        ];

        foreach ($categories as $item) {
            $this->createCategoryItem($item);
        }
    }

    protected function createCategoryItem(array $category, int $parentId = 0, int $index = 0): void
    {
        $category['parent_id'] = $parentId;
        $category['order'] = $index;
        $category['is_featured'] = true;

        if (Arr::has($category, 'children')) {
            $children = $category['children'];
            unset($category['children']);
        } else {
            $children = [];
        }

        $createdCategory = ProductCategory::query()->create(Arr::except($category, ['icon']));

        Slug::query()->create([
            'reference_type' => ProductCategory::class,
            'reference_id' => $createdCategory->id,
            'key' => Str::slug($createdCategory->name),
            'prefix' => SlugHelper::getPrefix(ProductCategory::class),
        ]);

        if ($children) {
            foreach ($children as $child) {
                $this->createCategoryItem($child, $createdCategory->id);
            }
        }
    }
}
