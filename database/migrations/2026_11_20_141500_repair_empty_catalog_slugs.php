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
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;

return new class () extends Migration {
    public function up(): void
    {
        $modelsToRepair = [
            ProductCategory::class => [
                'name_field' => 'name',
                'default_prefix' => 'product-categories',
            ],
            Product::class => [
                'name_field' => 'name',
                'default_prefix' => 'products',
                'scope' => fn ($query) => $query->where('is_variation', 0),
            ],
            ProductTag::class => [
                'name_field' => 'name',
                'default_prefix' => 'product-tags',
            ],
            ProductCollection::class => [
                'name_field' => 'name',
                'default_prefix' => 'product-collections',
            ],
            Brand::class => [
                'name_field' => 'name',
                'default_prefix' => 'brands',
            ],
            Page::class => [
                'name_field' => 'name',
                'default_prefix' => '',
            ],
            Post::class => [
                'name_field' => 'name',
                'default_prefix' => 'posts',
            ],
            BlogCategory::class => [
                'name_field' => 'name',
                'default_prefix' => 'categories',
            ],
            BlogTag::class => [
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

            $prefix = null;
            try {
                $prefix = SlugHelper::getPrefix($modelClass);
            } catch (\Throwable $e) {
                // Fallback to default
            }

            if ($prefix === null) {
                $prefix = $config['default_prefix'] ?? '';
            }

            $query = $modelClass::query();
            if (isset($config['scope'])) {
                $query = $config['scope']($query);
            }

            $items = $query->get();

            foreach ($items as $item) {
                $name = trim($item->{$config['name_field'] ?? 'name'} ?? '');
                if (empty($name)) {
                    $name = class_basename($modelClass) . '-' . $item->getKey();
                }

                // Check existing slug record
                $existingSlugs = Slug::query()
                    ->where('reference_type', $modelClass)
                    ->where('reference_id', $item->getKey())
                    ->get();

                $primarySlug = $existingSlugs->first();

                // If multiple slug records exist for this item, delete redundant duplicates
                if ($existingSlugs->count() > 1) {
                    $existingSlugs->slice(1)->each->delete();
                }

                // Repair if missing or key is empty
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

                    $totalRepaired++;
                }
            }
        }

        // Cleanup any leftover slugs with empty key that belong to deleted/non-existent references
        Slug::query()
            ->where(function ($query): void {
                $query->whereNull('key')->orWhere('key', '');
            })
            ->delete();

        Log::info("Repaired {$totalRepaired} empty catalog slugs in database.");
    }

    public function down(): void
    {
        // Slugs should remain populated; no rollback action needed.
    }
};
