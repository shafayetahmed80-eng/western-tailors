<?php

use Botble\Ecommerce\Models\ProductCategory;
use Botble\Widget\AbstractWidget;
use Illuminate\Support\Collection;

class ProductCategoriesWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Product Categories'),
            'description' => __('List all product categories'),
            'categories' => [],
            'style' => 'style-1',
        ]);
    }

    protected function data(): array|Collection
    {
        $categoryIds = $this->getConfig('categories');

        if (empty($categoryIds) || ! is_plugin_active('ecommerce')) {
            return [
                'categories' => [],
            ];
        }

        $categories = ProductCategory::query()
            ->whereIn('id', $categoryIds)
            ->wherePublished()
            ->with('slugable')
            ->withCount('products')
            ->get();

        return [
            'categories' => $categories,
        ];
    }
}
