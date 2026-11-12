<?php

use Botble\Ads\Facades\AdsManager;
use Botble\Base\Forms\FieldOptions\ButtonFieldOption;
use Botble\Base\Forms\FieldOptions\InputFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\UiSelectorFieldOption;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\MultiCheckListField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\UiSelectorField;
use Botble\Base\Forms\FormAbstract;
use Botble\Contact\Forms\Fronts\ContactForm;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Models\FlashSale;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Ecommerce\Models\ProductCollection;
use Botble\Faq\FaqCollection;
use Botble\Faq\FaqSupport;
use Botble\Faq\Models\FaqCategory;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\Fields\ShortcodeTagsField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Team\Models\Team;
use Botble\Testimonial\Models\Testimonial;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Theme\Ninico\Forms\ShortcodeContactAdminConfigForm;

app()->booted(function (): void {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    if (is_plugin_active('simple-slider')) {
        add_filter(SIMPLE_SLIDER_VIEW_TEMPLATE, function () {
            return Theme::getThemeNamespace('partials.shortcodes.simple-slider.index');
        });

        add_filter(SHORTCODE_REGISTER_CONTENT_IN_ADMIN, function (string $html, string $key, array $attributes) {
            if ($key !== 'simple-slider') {
                return $html;
            }

            $ads = [];

            if (is_plugin_active('ads')) {
                $ads = AdsManager::getData(true, true)->pluck('name', 'key')->all();
            }

            $form = ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->add(
                    'style',
                    UiSelectorField::class,
                    UiSelectorFieldOption::make()
                        ->choices(collect([
                            'wooden' => __('Wooden'),
                            'fashion' => __('Fashion'),
                            'furniture' => __('Furniture'),
                            'cosmetics' => __('Cosmetics'),
                            'grocery' => __('Grocery'),
                            'full-width' => __('Full width'),
                        ])->mapWithKeys(fn ($label, $key) => [
                            $key => [
                                'label' => $label,
                                'image' => Theme::asset()->url("images/shortcodes/simple-slider/$key.png"),
                            ],
                        ])->all())
                        ->selected(Arr::get($attributes, 'style', 1))
                        ->helperText(__('Full width style will only display the slider image without any text, action button or ads. The recommended image dimension is 1920x512 px.'))
                );

            for ($i = 1; $i <= 2; $i++) {
                $form->add('ads_' . $i, 'customSelect', [
                    'label' => __('Ads :number', ['number' => $i]),
                    'choices' => $ads,
                ]);
            }

            $form
                ->add('background_color', ColorField::class, [
                    'label' => __('Background color'),
                    'default_value' => '#f4f1ec',
                ])
                ->add(
                    'show_slider_image_on_mobile',
                    OnOffField::class,
                    OnOffFieldOption::make()
                        ->label(__('Show slider image on mobile'))
                )
                ->add(
                    'show_ads_title',
                    OnOffField::class,
                    OnOffFieldOption::make()
                        ->label(__('Show ads title'))
                        ->defaultValue(true)
                )
                ->add(
                    'show_slider_text',
                    OnOffField::class,
                    OnOffFieldOption::make()
                        ->label(__('Show slider text (For slider full width style)'))
                        ->defaultValue(false)
                )
                ->add('open_fieldset', 'html', [
                    'html' => '<fieldset class="form-fieldset"/>',
                ])
                ->add('alert', 'html', [
                    'html' => Theme::partial('shortcodes.partials.alert', ['title' => __('Settings in this section only works with style Grocery')]),
                ])
                ->add('background_image', 'mediaImage', [
                    'label' => __('Background image'),
                ])
                ->add('closed_fieldset', 'html', [
                    'html' => '</fieldset>',
                ]);

            return $html . $form->renderForm();
        }, 50, 3);
    }

    if (is_plugin_active('gallery')) {
        add_filter('galleries_box_template_view', function () {
            return Theme::getThemeNamespace('partials.shortcodes.galleries.index');
        });

        add_filter(SHORTCODE_REGISTER_CONTENT_IN_ADMIN, function (string $data, string $key, array $attributes) {
            if ($key !== 'gallery' && function_exists('get_galleries')) {
                return $data;
            }

            $form = ShortcodeForm::createFromArray($attributes)
                ->add('subtitle', 'text', [
                    'label' => __('Subtitle'),
                ])
                ->renderForm();

            return $data . $form;
        }, arguments: 3);
    }

    if (is_plugin_active('ecommerce')) {
        Shortcode::register(
            'product-categories',
            __('Product Categories'),
            __('Product Categories'),
            function (ShortcodeCompiler $shortcode) {
                $categoryIds = Shortcode::fields()->getIds('category_ids', $shortcode);

                if (! $categoryIds) {
                    return null;
                }

                $categories = ProductCategory::query()
                    ->whereIn('id', $categoryIds)
                    ->wherePublished()
                    ->with('slugable')
                    ->withCount('products')
                    ->orderBy('order')
                    ->orderByDesc('created_at')
                    ->get();

                if ($categories->isEmpty()) {
                    return null;
                }

                $style = ! in_array($shortcode->style, ['wooden', 'fashion', 'cosmetics']) ? 'wooden' : $shortcode->style;

                return Theme::partial(
                    "shortcodes.product-categories.styles.$style",
                    compact('shortcode', 'categories')
                );
            }
        );

        Shortcode::setAdminConfig('product-categories', function (array $attributes) {
            return ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->add('title', 'text', [
                    'label' => __('Title'),
                    'help_block' => [
                        'text' => __('Wrapper text into <code>:tag</code> tag to make it highlight.', ['tag' => '&lt;span&gt;text&lt;/span&gt;']),
                    ],
                ])
                ->add('category_ids', ShortcodeTagsField::class, [
                    'label' => __('Categories'),
                    'attr' => [
                        'placeholder' => __('Choose categories'),
                    ],
                    'choices' => ProductCategory::query()
                        ->wherePublished()
                        ->pluck('name', 'id')
                        ->all(),
                ])
                ->add('style', 'customSelect', [
                    'label' => __('Style'),
                    'choices' => [
                        'wooden' => __('Wooden'),
                        'fashion' => __('Fashion'),
                        'cosmetics' => __('Cosmetics'),
                    ],
                ]);
        });

        Shortcode::register(
            'products-by-categories',
            __('Products by Categories'),
            __('Products by Categories'),
            function (ShortcodeCompiler $shortcode) {
                $categoryIds = Shortcode::fields()->getIds('category_ids', $shortcode);

                if (! $categoryIds) {
                    return null;
                }

                $categories = ProductCategory::query()
                    ->wherePublished()
                    ->whereIn('id', $categoryIds)
                    ->get();

                if ($categories->isEmpty()) {
                    return null;
                }

                foreach ($categories as $category) {
                    $category->load(['products' => function (BelongsToMany $query) use ($shortcode) {
                        $reviewParams = EcommerceHelper::withReviewsParams();

                        if (EcommerceHelper::isReviewEnabled()) {
                            $query->withAvg($reviewParams['withAvg'][0], $reviewParams['withAvg'][1]);
                        }

                        $query
                            ->wherePublished()
                            ->orderByDesc('created_at')
                            ->when($shortcode->random_products === 'yes', fn ($query) => $query->inRandomOrder())
                            ->limit((int) $shortcode->number_of_products ?: 4);
                    }]);
                }

                return Theme::partial(
                    'shortcodes.products-by-categories.index',
                    compact('shortcode', 'categories')
                );
            }
        );

        Shortcode::setAdminConfig('products-by-categories', function (array $attributes) {
            return ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->add('category_ids', ShortcodeTagsField::class, [
                    'label' => __('Categories'),
                    'attr' => [
                        'placeholder' => __('Choose categories'),
                    ],
                    'choices' => ProductCategory::query()
                        ->wherePublished()
                        ->pluck('name', 'id')
                        ->all(),
                ])
                ->add('number_of_products', 'number', [
                    'label' => __('Number of products per category'),
                    'default_value' => 4,
                    'attr' => [
                        'placeholder' => __('Number of products per category'),
                    ],
                ])
                ->add(
                    'random_products',
                    SelectField::class,
                    SelectFieldOption::make()
                        ->label(__('Random products'))
                        ->choices([
                            'no' => __('No'),
                            'yes' => __('Yes'),
                        ])
                );
        });

        Shortcode::register('products', __('Products'), __('Products'), function (ShortcodeCompiler $shortcode) {
            $tabs = [
                'all' => __('All'),
                'featured' => __('Featured'),
                'on-sale' => __('On sale'),
                'trending' => __('Trending'),
                'top-rated' => __('Top rated'),
            ];

            $selectedTabs = array_filter(explode(',', $shortcode->tabs));

            if (empty($selectedTabs)) {
                $selectedTabs = array_keys($tabs);
            }

            return Theme::partial('shortcodes.products.index', compact('shortcode', 'tabs', 'selectedTabs'));
        });

        Shortcode::setAdminConfig('products', function (array $attributes) {
            $tabs = [
                'all' => __('All'),
                'featured' => __('Featured'),
                'on-sale' => __('On sale'),
                'trending' => __('Trending'),
                'top-rated' => __('Top rated'),
            ];

            $selectedTabs = array_filter(explode(',', Arr::get($attributes, 'tabs')));

            if (empty($selectedTabs)) {
                $selectedTabs = array_keys($tabs);
            }

            return ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->add('title', 'text', [
                    'label' => __('Title'),
                    'attr' => [
                        'placeholder' => __('Title'),
                    ],
                ])
                ->add('limit', 'number', [
                    'label' => __('Limit'),
                    'attr' => [
                        'placeholder' => __('Number of categories to display'),
                    ],
                ])
                ->add('tabs[]', MultiCheckListField::class, [
                    'label' => __('Tabs'),
                    'choices' => $tabs,
                    'value' => $selectedTabs,
                ]);
        });

        Shortcode::register('deal-product', __('Deal Product'), __('Deal Product'), function (ShortcodeCompiler $shortcode) {
            if (! $shortcode->flash_sale_id) {
                return null;
            }

            $limit = (int) $shortcode->limit ?: 10;

            $style = $shortcode->style;

            $flashSale = FlashSale::query()
                ->wherePublished()
                ->notExpired()
                ->with([
                    'products' => function (BelongsToMany $query) use ($limit, $style) {
                        $reviewParams = EcommerceHelper::withReviewsParams();

                        if (EcommerceHelper::isReviewEnabled()) {
                            $query->withAvg($reviewParams['withAvg'][0], $reviewParams['withAvg'][1]);
                        }

                        if ($style !== 'list-products') {
                            $query = $query->inRandomOrder()->limit(1);
                        } else {
                            $query = $query->limit($limit);
                        }

                        return $query
                            ->wherePublished()
                            ->with(EcommerceHelper::withProductEagerLoadingRelations())
                            ->withCount($reviewParams['withCount']);
                    },
                ])
                ->withCount('products')
                ->find($shortcode->flash_sale_id);

            if (! $flashSale || $flashSale->products_count === 0) {
                return null;
            }

            $product = $flashSale->products->first();

            if (! $product) {
                return null;
            }

            $style = ! in_array($shortcode->style, ['wooden', 'cosmetics', 'list-products']) ? 'wooden' : $shortcode->style;

            return Theme::partial('shortcodes.deal-product.index', compact('shortcode', 'style', 'flashSale', 'product'));
        });

        Shortcode::setAdminConfig('deal-product', function (array $attributes) {
            $flashSales = FlashSale::query()
                ->wherePublished()
                ->notExpired()
                ->pluck('name', 'id')
                ->all();

            return ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->add(
                    'flash_sale_id',
                    SelectField::class,
                    SelectFieldOption::make()->label(__('Flash sale'))->choices($flashSales)->toArray()
                )
                ->add(
                    'style',
                    SelectField::class,
                    SelectFieldOption::make()
                        ->label(__('Style'))
                        ->choices([
                            'wooden' => __('Wooden (random product)'),
                            'cosmetics' => __('Cosmetics (random product)'),
                            'list-products' => __('List products'),
                        ])
                        ->attributes([
                            'data-bb-toggle' => 'collapse',
                            'data-bb-target' => '#deal-product-style',
                        ])
                        ->toArray()
                )
                ->add(
                    'title',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Title'))
                        ->helperText(__('Leave blank to use flash sale name (shown on "List products" style)'))
                        ->toArray()
                )
                ->add('background_color', ColorField::class, [
                    'label' => __('Background color'),
                    'default_value' => '#f8f8f8',
                ])
                ->add('open_fieldset', 'html', [
                    'html' => sprintf(
                        '<fieldset class="form-fieldset" id="deal-product-style" data-bb-value="cosmetics" style="display: %s" />',
                        Arr::get($attributes, 'style') === 'cosmetics' ? 'block' : 'none'
                    ),
                ])
                ->add('alert', 'html', [
                    'html' => Theme::partial('shortcodes.partials.alert', ['title' => __('Marque only works with cosmetics style.')]),
                ])
                ->add('marque_text', 'text', [
                    'label' => __('Marque text'),
                ])
                ->add('marque_highlight_text', 'text', [
                    'label' => __('Marque highlight text'),
                ])
                ->add('marque_highlight_url', 'text', [
                    'label' => __('Marque highlight URL'),
                ])
                ->add('highlight_background', 'mediaImage', [
                    'label' => __('Highlight background image'),
                ])
                ->add('close_fieldset', 'html', [
                    'html' => '</fieldset>',
                ]);
        });

        Shortcode::register('products-slide', __('Products Slide'), __('Products Slide'), function (ShortcodeCompiler $shortcode) {
            $params = array_merge([
                'take' => (int) $shortcode->limit ?: 5,
            ], EcommerceHelper::withReviewsParams());

            $products = match ($shortcode->type) {
                'featured' => get_featured_products($params),
                'trending' => get_trending_products($params),
                default => get_products($params),
            };

            return Theme::partial('shortcodes.products-slide.index', compact('shortcode', 'products'));
        });

        Shortcode::setAdminConfig('products-slide', function (array $attributes) {
            return ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->add('title', 'text', [
                    'label' => __('Title'),
                    'attr' => [
                        'placeholder' => __('Title'),
                    ],
                ])
                ->add('limit', 'number', [
                    'label' => 'Limit',
                    'attr' => [
                        'placeholder' => __('Number of products to display'),
                    ],
                ])
                ->add('type', 'customSelect', [
                    'label' => __('Type'),
                    'choices' => [
                        'featured' => __('Featured'),
                        'trending' => __('Trending'),
                        'latest' => __('Latest'),
                    ],
                ])
                ->add('background_color', ColorField::class, [
                    'label' => __('Background color'),
                    'default_value' => '#f3f4f7',
                ]);
        });

        Shortcode::register('product-collections', __('Product Collections'), __('Product Collections'), function (ShortcodeCompiler $shortcode) {
            $collectionIds = Shortcode::fields()->getIds('collection_ids', $shortcode);

            if (! $collectionIds) {
                return null;
            }

            $collections = ProductCollection::query()
                ->wherePublished()
                ->whereIn('id', $collectionIds)
                ->get();

            if ($collections->isEmpty()) {
                return null;
            }

            return Theme::partial('shortcodes.product-collections.index', compact('shortcode', 'collections'));
        });

        Shortcode::setAdminConfig('product-collections', function (array $attributes) {
            return ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->add('collection_ids', ShortcodeTagsField::class, [
                    'label' => __('Collections'),
                    'attr' => [
                        'placeholder' => __('Choose collections'),
                    ],
                    'choices' => ProductCollection::query()
                        ->wherePublished()
                        ->pluck('name', 'id')
                        ->all(),
                ]);
        });
    }

    if (is_plugin_active('ads')) {
        Shortcode::register('theme-ads', __('Theme Ads'), __('Theme Ads'), function (ShortcodeCompiler $shortcode) {
            return Theme::partial('shortcodes.theme-ads.index', compact('shortcode'));
        });

        Shortcode::setAdminConfig('theme-ads', function (array $attributes) {
            $ads = AdsManager::getData(true, true);

            $form =  ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->add('style', 'customSelect', [
                    'label' => __('Style'),
                    'choices' => [
                        'fashion' => __('Fashion'),
                        'furniture' => __('Furniture'),
                    ],
                ]);

            $keys = $ads->pluck('name', 'key')->merge(['' => __('-- Select --')])->sortKeys()->toArray();

            for ($i = 1; $i <= 3; $i++) {
                $form->add('key_' . $i, 'customSelect', [
                    'label' => __('Ad :number', ['number' => $i]),
                    'choices' => $keys,
                ]);
            }

            return $form;
        });
    }

    if (is_plugin_active('blog')) {
        Shortcode::register(
            'featured-posts',
            __('Featured Posts'),
            __('Featured Posts'),
            function (ShortcodeCompiler $shortcode) {
                $limit = (int) $shortcode->limit ?: 4;

                $posts = match ($shortcode->type) {
                    'featured' => get_featured_posts($limit),
                    'popular' => get_popular_posts($limit),
                    'recent' => get_recent_posts($limit),
                    default => get_latest_posts($limit),
                };

                return Theme::partial('shortcodes.featured-posts.' . ($shortcode->style == 'has-sidebar' ? 'with-sidebar' : 'index'), compact('shortcode', 'posts'));
            }
        );

        Shortcode::setAdminConfig('featured-posts', function (array $attributes) {
            return ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->add('title', 'text', [
                    'label' => __('Title'),
                    'help_block' => [
                        'text' => __('Wrapper text into <code>:tag</code> tag to make it highlight.', ['tag' => '&lt;span&gt;text&lt;/span&gt;']),
                    ],
                ])
                ->add('limit', 'number', [
                    'label' => __('Limit'),
                    'attr' => [
                        'placeholder' => __('Number of posts to display'),
                    ],
                ])
                ->add('type', 'customSelect', [
                    'label' => __('Post type'),
                    'choices' => [
                        '' => __('Latest'),
                        'featured' => __('Featured'),
                        'popular' => __('Popular'),
                        'recent' => __('Recent'),
                    ],
                ])
                ->add('url', 'text', [
                    'label' => __('URL'),
                    'attr' => [
                        'placeholder' => __('URL'),
                    ],
                ])
                ->add(
                    'text_color',
                    ColorField::class,
                    InputFieldOption::make()
                        ->label(__('Text color'))
                        ->defaultValue('#040404')
                        ->toArray()
                )
                ->add(
                    'background_color',
                    ColorField::class,
                    InputFieldOption::make()
                        ->label(__('Background color'))
                        ->defaultValue('#F8F8F8')
                        ->toArray()
                )
                ->add(
                    'style',
                    SelectField::class,
                    SelectFieldOption::make()
                        ->choices([
                            null => __('Default'),
                            'has-sidebar' => __('Has sidebar'),
                        ])
                        ->label(__('Style'))
                        ->toArray()
                );
        });
    }

    if (is_plugin_active('team')) {
        Shortcode::register('team', __('Team'), __('Team'), function (ShortcodeCompiler $shortcode) {
            $teamIds = Shortcode::fields()->getIds('team_ids', $shortcode);

            if (! $teamIds) {
                return null;
            }

            $teams = Team::query()
                ->whereIn('id', $teamIds)
                ->get();

            if ($teams->isEmpty()) {
                return null;
            }

            return Theme::partial('shortcodes.team.index', compact('shortcode', 'teams'));
        });

        Shortcode::setAdminConfig('team', function (array $attributes) {
            return ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->add('title', 'text', [
                    'label' => __('Title'),
                ])
                ->add('subtitle', 'text', [
                    'label' => __('Subtitle'),
                ])
                ->add('team_ids', 'text', [
                    'label' => __('Teams'),
                    'attr' => [
                        'placeholder' => __('Choose teams'),
                    ],
                    'choices' => Team::query()
                        ->wherePublished()
                        ->latest()
                        ->pluck('name', 'id')
                        ->all(),
                ]);
        });
    }

    if (is_plugin_active('contact')) {
        add_filter(CONTACT_FORM_TEMPLATE_VIEW, function () {
            return Theme::getThemeNamespace('partials.shortcodes.contact-form.index');
        });

        ContactForm::beforeRendering(function (ContactForm $form) {
            return $form
                ->remove('submit')
                ->add('submit', 'submit', ButtonFieldOption::make()
                    ->cssClass('tp-btn tp-color-btn tp-wish-cart')
                    ->label(__('Get A Quote') . '<i class="fal fa-long-arrow-right"></i>')
                    ->toArray());
        }, 120);

        Shortcode::setAdminConfig('contact-form', function (array $attributes) {
            return ShortcodeContactAdminConfigForm::createFromArray($attributes);
        });

        Shortcode::register('contact-box', __('Contact Box (deprecated)'), __('Contact Box'), function (ShortcodeCompiler $shortcode) {
            return do_shortcode(Shortcode::generateShortcode('contact-form', $shortcode->toArray()));
        });

        Shortcode::setAdminConfig('contact-box', function (array $attributes) {
            return ShortcodeContactAdminConfigForm::createFromArray($attributes);
        });
    }

    if (is_plugin_active('faq')) {
        Shortcode::register('faqs', __('FAQs'), __('FAQs'), function (ShortcodeCompiler $shortcode): ?string {
            $categoryIds = Shortcode::fields()->getIds('category_ids', $shortcode);

            if (empty($categoryIds)) {
                return null;
            }

            $categories = FaqCategory::query()
                ->wherePublished()
                ->whereIn('id', $categoryIds)
                ->with('faqs', fn (HasMany $query) => $query->wherePublished())
                ->get();

            $faqs = $categories->flatMap->faqs;

            if ($faqs->isNotEmpty()) {
                (new FaqSupport())->registerSchema(FaqCollection::make($faqs));
            }

            return Theme::partial('shortcodes.faqs.index', compact('shortcode', 'categories'));
        });

        Shortcode::setAdminConfig('faqs', function (array $attributes): FormAbstract {
            $categories = FaqCategory::query()
                ->pluck('name', 'id')
                ->all();

            $categoryIds = explode(',', Arr::get($attributes, 'category_ids'));

            return ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->add(
                    'category_ids',
                    SelectField::class,
                    SelectFieldOption::make()
                        ->label(__('Categories'))
                        ->searchable()
                        ->choices($categories)
                        ->selected($categoryIds)
                        ->multiple()
                        ->toArray()
                );
        });
    }

    Shortcode::register('about', __('About'), __('About'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.about.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('about', function (array $attributes) {
        $form = ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->columns()
            ->add('image_1', 'mediaImage', [
                'label' => __('Image :number', ['number' => 1]),
            ])
            ->add('image_2', 'mediaImage', [
                'label' => __('Image :number', ['number' => 2]),
            ])
            ->add('logo', 'mediaImage', [
                'label' => __('Logo'),
                'colspan' => 2,
            ])
            ->add('title', 'text', [
                'label' => __('Title'),
                'colspan' => 2,
            ])
            ->add('subtitle', 'text', [
                'label' => __('Subtitle'),
                'colspan' => 2,
            ])
            ->add('story_text_1', 'textarea', [
                'label' => __('Story text :number', ['number' => 1]),
                'attr' => [
                    'rows' => 3,
                ],
                'colspan' => 2,
            ])
            ->add('story_text_2', 'textarea', [
                'label' => __('Story text :number', ['number' => 2]),
                'attr' => [
                    'rows' => 3,
                ],
                'colspan' => 2,
            ]);

        for ($i = 1; $i <= 5; $i++) {
            $form
                ->add('list_item_' . $i, 'text', [
                    'label' => __('List item :number', ['number' => $i]),
                    'colspan' => 2,
                ])
                ->add('list_item_url_' . $i, 'text', [
                    'label' => __('List item url :number', ['number' => $i]),
                    'colspan' => 2,
                ]);
        }

        return $form;
    });

    Shortcode::register('features', __('Features'), __('Features'), function (ShortcodeCompiler $shortcode) {
        $quantity = min((int) $shortcode->quantity, 5);

        return Theme::partial('shortcodes.features.index', compact('shortcode', 'quantity'));
    });

    Shortcode::setAdminConfig('features', function (array $attributes) {
        $fields = [
            'title' => [
                'type' => 'text',
                'title' => __('Title'),
                'required' => true,
            ],
            'subtitle' => [
                'type' => 'text',
                'title' => __('Subtitle'),
            ],
            'description' => [
                'type' => 'textarea',
                'title' => __('Description'),
            ],
            'image' => [
                'type' => 'image',
                'title' => __('Image'),
            ],
            'button_label' => [
                'type' => 'text',
                'title' => __('Button label'),
            ],
            'button_url' => [
                'type' => 'text',
                'title' => __('Button URL'),
            ],
        ];

        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add('feature_tabs', 'tabs', [
                'fields' => $fields,
                'shortcode_attributes' => $attributes,
                'max' => 5,
            ]);
    });

    Shortcode::register('coming-soon', __('Coming Soon'), __('Coming Soon'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.coming-soon.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('coming-soon', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add('title', 'text', [
                'label' => __('Title'),
            ])
            ->add('subtitle', 'text', [
                'label' => __('Subtitle'),
            ])
            ->add('time', 'date', [
                'label' => __('Time end'),
            ])
            ->add('background_image', 'mediaImage', [
                'label' => __('Background image'),
            ])
            ->add('logo_style', 'customSelect', [
                'label' => __('Logo style'),
                'choices' => [
                    theme_option('logo_light') => __('Light'),
                    theme_option('logo_dark') => __('Dark'),
                ],
            ])
            ->add('show_subscribe_form', 'customSelect', [
                'label' => __('Show subscribe form?'),
                'choices' => [
                    0 => __('No'),
                    1 => __('Yes'),
                ],
            ]);
    });

    Shortcode::register('shop-location', __('Shop Location'), __('Shop Location'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.shop-location.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('shop-location', function (array $attributes) {
        $attributes['quantity'] = 4;

        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add('shop_location_tabs', 'tabs', [
                'fields' => [
                    'name' => [
                        'type' => 'text',
                        'title' => __('Name'),
                        'required' => true,
                    ],
                    'address' => [
                        'type' => 'text',
                        'title' => __('Address'),
                    ],
                    'phone' => [
                        'type' => 'text',
                        'title' => __('Phone number'),
                    ],
                    'hours' => [
                        'type' => 'text',
                        'title' => __('Store hours'),
                    ],
                    'image' => [
                        'type' => 'image',
                        'title' => __('Image'),
                    ],
                ],
                'shortcode_attributes' => $attributes,
                'max' => 10,
            ]);
    });

    Shortcode::register('services', __('Services'), __('Services'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.services.index', compact('shortcode'));
    });

    Shortcode::setPreviewImage('services', Theme::asset()->url('images/shortcodes/services.png'));

    Shortcode::setAdminConfig('services', function (array $attributes) {
        $fields = [
            'title' => [
                'type' => 'text',
                'title' => __('Title'),
                'required' => true,
            ],
            'url' => [
                'type' => 'text',
                'title' => __('URL'),
            ],
            'description' => [
                'type' => 'text',
                'title' => __('Description'),
            ],
            'image' => [
                'type' => 'image',
                'title' => __('Image'),
            ],
        ];

        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'items_per_view',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(__('Items per view'))
                    ->defaultValue(4)
            )
            ->add('service_tabs', 'tabs', [
                'fields' => $fields,
                'shortcode_attributes' => $attributes,
            ]);
    });

    Shortcode::register('brands', __('Brands'), __('Brands'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.brands.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('brands', function (array $attributes) {
        $fields = [
            'name' => [
                'title' => __('Name'),
                'required' => true,
            ],
            'image' => [
                'type' => 'image',
                'title' => __('Logo'),
                'required' => true,
            ],
            'link' => [
                'type' => 'text',
                'title' => __('URL'),
                'required' => false,
            ],
        ];

        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add('title', 'text', [
                'label' => __('Title'),
            ])
            ->add('title_color', ColorField::class, [
                'label' => __('Title text color'),
                'default_value' => '#040404',
            ])
            ->add('background_color', ColorField::class, [
                'label' => __('Background color'),
                'default_value' => 'transparent',
            ])
            ->add('background_image', 'mediaImage', [
                'label' => __('Background image'),
            ])
            ->add('brand_tabs', 'tabs', [
                'fields' => $fields,
                'shortcode_attributes' => $attributes,
            ]);
    });

    if (is_plugin_active('testimonial')) {
        Shortcode::register('testimonials', __('Testimonials'), __('Testimonials'), function (ShortcodeCompiler $shortcode): ?string {
            $testimonials = Testimonial::query()
                ->wherePublished()
                ->limit((int) $shortcode->limit ?: 4)
                ->get();

            if ($testimonials->isEmpty()) {
                return null;
            }

            return Theme::partial('shortcodes.testimonials.index', compact('shortcode', 'testimonials'));
        });

        Shortcode::setAdminConfig('testimonials', function (array $attributes) {
            return ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->columns()
                ->add('title', 'text', [
                    'label' => __('Title'),
                    'colspan' => 2,
                ])
                ->add('limit', 'number', [
                    'label' => __('Limit'),
                    'colspan' => 2,
                ])
                ->add('background_color', ColorField::class, [
                    'label' => __('Background color'),
                    'default_value' => '#fff',
                ])
                ->add('card_color', ColorField::class, [
                    'label' => __('Card color'),
                    'default_value' => '#fcf6f4',
                ]);
        });
    }
});
