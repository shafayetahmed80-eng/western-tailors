<?php

use Botble\Widget\AbstractWidget;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class BlogTagsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Blog Tags'),
            'description' => __('Display blog tags'),
            'limit' => 12,
        ]);
    }

    public function data(): array|Collection
    {
        if (! is_plugin_active('blog')) {
            return [];
        }

        $config = $this->getConfig();

        $limit = (int) Arr::get($config, 'limit', 12);
        $tags = get_popular_tags($limit);

        return compact('tags');
    }
}
