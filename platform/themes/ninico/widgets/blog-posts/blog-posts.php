<?php

use Botble\Widget\AbstractWidget;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class BlogPostsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Blog Posts'),
            'description' => __('Display blog posts'),
            'number_display' => 4,
        ]);
    }

    public function data(): array|Collection
    {
        if (! is_plugin_active('blog')) {
            return [];
        }

        $config = $this->getConfig();

        $limit = (int) Arr::get($config, 'limit', 4);

        $posts = match (Arr::get($config, 'type')) {
            'featured' => get_featured_posts($limit),
            'popular' => get_popular_posts($limit),
            'recent' => get_recent_posts($limit),
            default => get_latest_posts($limit),
        };

        return compact('posts');
    }
}
