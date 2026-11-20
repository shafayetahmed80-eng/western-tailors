<?php

use Botble\Blog\Models\Category as BlogCategory;
use Botble\Blog\Models\Post;
use Botble\Blog\Models\Tag as BlogTag;
use Botble\Ecommerce\Models\Brand;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Ecommerce\Models\ProductCollection;
use Botble\Ecommerce\Models\ProductTag;
use Botble\Page\Models\Page;
use Botble\Slug\Facades\SlugHelper;
use Botble\Slug\Models\Slug;
use Botble\Slug\Services\SlugService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('bespoke:repair-slugs', function () {
    $this->info('Scanning and repairing missing or empty catalog slugs...');

    $modelsToRepair = [
        ProductCategory::class => [
            'label' => 'Product Categories',
            'name_field' => 'name',
            'default_prefix' => 'product-categories',
        ],
        Product::class => [
            'label' => 'Products',
            'name_field' => 'name',
            'default_prefix' => 'products',
            'scope' => fn ($query) => $query->where('is_variation', 0),
        ],
        ProductTag::class => [
            'label' => 'Product Tags',
            'name_field' => 'name',
            'default_prefix' => 'product-tags',
        ],
        ProductCollection::class => [
            'label' => 'Product Collections',
            'name_field' => 'name',
            'default_prefix' => 'product-collections',
        ],
        Brand::class => [
            'label' => 'Brands',
            'name_field' => 'name',
            'default_prefix' => 'brands',
        ],
        Page::class => [
            'label' => 'Pages',
            'name_field' => 'name',
            'default_prefix' => '',
        ],
        Post::class => [
            'label' => 'Blog Posts',
            'name_field' => 'name',
            'default_prefix' => 'posts',
        ],
        BlogCategory::class => [
            'label' => 'Blog Categories',
            'name_field' => 'name',
            'default_prefix' => 'categories',
        ],
        BlogTag::class => [
            'label' => 'Blog Tags',
            'name_field' => 'name',
            'default_prefix' => 'tags',
        ],
    ];

    $slugService = new SlugService();
    $totalRepaired = 0;

    foreach ($modelsToRepair as $modelClass => $config) {
        if (! class_exists($modelClass)) {
            continue;
        }

        $label = $config['label'] ?? class_basename($modelClass);
        $prefix = null;
        try {
            $prefix = SlugHelper::getPrefix($modelClass);
        } catch (\Throwable $e) {
            // fallback
        }

        if ($prefix === null) {
            $prefix = $config['default_prefix'] ?? '';
        }

        $query = $modelClass::query();
        if (isset($config['scope'])) {
            $query = $config['scope']($query);
        }

        $items = $query->get();
        $modelRepaired = 0;

        foreach ($items as $item) {
            $name = trim($item->{$config['name_field'] ?? 'name'} ?? '');
            if (empty($name)) {
                $name = class_basename($modelClass) . '-' . $item->getKey();
            }

            $existingSlugs = Slug::query()
                ->where('reference_type', $modelClass)
                ->where('reference_id', $item->getKey())
                ->get();

            $primarySlug = $existingSlugs->first();

            if ($existingSlugs->count() > 1) {
                $existingSlugs->slice(1)->each->delete();
            }

            if (! $primarySlug || empty(trim((string) $primarySlug->key))) {
                $slugId = $primarySlug ? $primarySlug->getKey() : 0;
                $slugKey = $slugService->create($name, $slugId, $modelClass);

                if ($primarySlug) {
                    $primarySlug->update([
                        'key' => $slugKey,
                        'prefix' => $prefix,
                    ]);
                } else {
                    Slug::query()->create([
                        'key' => $slugKey,
                        'reference_type' => $modelClass,
                        'reference_id' => $item->getKey(),
                        'prefix' => $prefix,
                    ]);
                }

                $modelRepaired++;
                $totalRepaired++;
            }
        }

        $this->line(sprintf('  * %s: %d repaired (out of %d items)', $label, $modelRepaired, $items->count()));
    }

    $deletedEmpty = Slug::query()
        ->where(function ($query): void {
            $query->whereNull('key')->orWhere('key', '');
        })
        ->delete();

    if ($deletedEmpty > 0) {
        $this->comment("  * Cleaned {$deletedEmpty} orphaned empty slugs.");
    }

    $this->info("Done! Total repaired slugs: {$totalRepaired}.");
})->purpose('Repair missing or empty slugs across all catalog and content models');

