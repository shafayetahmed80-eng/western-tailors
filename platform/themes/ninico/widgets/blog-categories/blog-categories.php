<?php

use Botble\Blog\Models\Category;
use Botble\Widget\AbstractWidget;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class BlogCategoriesWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Blog Categories',
            'description' => __('Display blog categories'),
            'number_display' => 6,
        ]);
    }

    public function data(): array|Collection
    {
        if (! is_plugin_active('blog')) {
            return [];
        }

        $categories = Category::query()
            ->wherePublished()
            ->take(Arr::get($this->getConfig(), 'limit', 6))
            ->with('slugable')
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->get();

        return [
            'categories' => $categories,
        ];
    }
}
