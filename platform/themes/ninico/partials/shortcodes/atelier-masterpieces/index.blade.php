@php
    $perCat = max(2, min(8, (int) ($shortcode->per_category ?: 4)));
    $catalogItems = [];
    $seenIds = [];

    $cleanText = static function (?string $str): string {
        if ($str === null || $str === '') {
            return '';
        }
        return strtr($str, [
            "\xC3\xA0\xC2\xA7\xC2\xB3" => "\u{09F3}",
            'à§³' => '৳',
            'â€™' => '’',
            'â€˜' => '‘',
            'â€œ' => '“',
            'â€' => '”',
            'â€“' => '–',
            'â€”' => '—',
            'Â ' => ' ',
            'Â' => '',
        ]);
    };

    $groups = [
        'sherwani' => [
            'label' => 'Sherwani',
            'fabric' => 'Raw Mulberry Silk • Hand-Zardozi',
            'cat_ids' => [38, 39, 40, 41, 42, 43, 44, 45, 46, 71, 27, 28],
            'fallback_img' => 'https://images.unsplash.com/photo-1617137968427-85924c800a22?auto=format&fit=crop&w=650&q=80',
        ],
        'suits' => [
            'label' => 'Suits',
            'fabric' => 'Biella Super 150s Wool • Full Canvas',
            'cat_ids' => [72, 26, 23, 25, 24, 29, 30, 21],
            'fallback_img' => 'https://images.unsplash.com/photo-1593030761757-71fae45fa0e7?auto=format&fit=crop&w=650&q=80',
        ],
        'gurkha' => [
            'label' => 'Gurkha',
            'fabric' => 'Egyptian Cotton Twill • Brass Buckles',
            'cat_ids' => [33, 35, 37, 32, 34, 36],
            'fallback_img' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?auto=format&fit=crop&w=650&q=80',
        ],
        'tuxedos' => [
            'label' => 'Tuxedos',
            'fabric' => 'Como Silk Velvet • Satin Peak Lapel',
            'cat_ids' => [19, 65, 66, 67],
            'fallback_img' => 'https://images.unsplash.com/photo-1555069519-127aadedf1ee?auto=format&fit=crop&w=650&q=80',
        ],
    ];

    if (is_plugin_active('ecommerce')) {
        foreach ($groups as $groupKey => $meta) {
            $query = \Botble\Ecommerce\Models\Product::query()
                ->wherePublished()
                ->where('is_variation', 0)
                ->whereHas('categories', function ($q) use ($meta) {
                    $q->whereIn('ec_product_categories.id', $meta['cat_ids']);
                })
                ->with(['slugable', 'categories'])
                ->when(! empty($seenIds), fn ($q) => $q->whereNotIn('id', $seenIds))
                ->orderByDesc('is_featured')
                ->latest('id')
                ->limit($perCat)
                ->get();

            foreach ($query as $prod) {
                $seenIds[] = $prod->id;
                $cleanDesc = trim(strip_tags((string) ($prod->description ?: $prod->content)));
                if ($cleanDesc === '') {
                    $cleanDesc = 'Hand-drafted bespoke garment tailored to your individual posture, silhouette, and finish preference at our Dhaka house.';
                } else {
                    $cleanDesc = \Illuminate\Support\Str::limit($cleanDesc, 165);
                }

                $catalogItems[] = [
                    'id' => (string) $prod->id,
                    'productId' => (int) $prod->id,
                    'name' => $cleanText($prod->name),
                    'group' => $groupKey,
                    'category' => $meta['label'],
                    'priceFormatted' => $cleanText(format_price($prod->front_sale_price_with_taxes)),
                    'fabric' => $meta['fabric'],
                    'desc' => $cleanText($cleanDesc),
                    'image' => RvMedia::getImageUrl($prod->image, 'small', false, $meta['fallback_img']),
                    'imageLarge' => RvMedia::getImageUrl($prod->image, null, false, $meta['fallback_img']),
                    'fallback' => $meta['fallback_img'],
                    'url' => $prod->url,
                    'hasVariations' => (bool) $prod->variations()->exists(),
                    'addToCartUrl' => EcommerceHelper::isCartEnabled() ? route('public.cart.add-to-cart') : '',
                ];
            }
        }
    }

    // Graceful showcase fallback when running against an empty database
    if (empty($catalogItems)) {
        $catalogItems = [
            [
                'id' => 'wb-m1',
                'productId' => 0,
                'name' => 'Sand Beige Gurkha Trousers',
                'group' => 'gurkha',
                'category' => 'Gurkha',
                'priceFormatted' => '৳ 2,850',
                'fabric' => 'Egyptian Cotton Twill • Brass Buckles',
                'desc' => 'Signature high-rise Gurkha silhouette with double forward pleats and hand-finished side adjusters.',
                'image' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?auto=format&fit=crop&w=650&q=80',
                'imageLarge' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?auto=format&fit=crop&w=900&q=80',
                'fallback' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?auto=format&fit=crop&w=650&q=80',
                'url' => url('products'),
                'hasVariations' => false,
                'addToCartUrl' => '',
            ],
            [
                'id' => 'wb-m2',
                'productId' => 0,
                'name' => 'Midnight Embroidered Prince Coat',
                'group' => 'sherwani',
                'category' => 'Sherwani',
                'priceFormatted' => '৳ 18,500',
                'fabric' => 'Italian Merino • Hand-Zardozi',
                'desc' => 'Structured mandarin-collar Prince Coat finished with antique gold zardozi embroidery along the cuffs and lapel.',
                'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?auto=format&fit=crop&w=650&q=80',
                'imageLarge' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?auto=format&fit=crop&w=900&q=80',
                'fallback' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?auto=format&fit=crop&w=650&q=80',
                'url' => url('products'),
                'hasVariations' => false,
                'addToCartUrl' => '',
            ],
            [
                'id' => 'wb-m3',
                'productId' => 0,
                'name' => 'Charcoal Double-Breasted Suit',
                'group' => 'suits',
                'category' => 'Suits',
                'priceFormatted' => '৳ 35,000',
                'fabric' => 'Biella Super 150s Wool • Full Canvas',
                'desc' => 'Architectural 6x2 double-breasted Savile Row silhouette with roped shoulders and horn buttons.',
                'image' => 'https://images.unsplash.com/photo-1593030761757-71fae45fa0e7?auto=format&fit=crop&w=650&q=80',
                'imageLarge' => 'https://images.unsplash.com/photo-1593030761757-71fae45fa0e7?auto=format&fit=crop&w=900&q=80',
                'fallback' => 'https://images.unsplash.com/photo-1593030761757-71fae45fa0e7?auto=format&fit=crop&w=650&q=80',
                'url' => url('products'),
                'hasVariations' => false,
                'addToCartUrl' => '',
            ],
            [
                'id' => 'wb-m4',
                'productId' => 0,
                'name' => 'Ivory Zardozi Groom Sherwani',
                'group' => 'sherwani',
                'category' => 'Sherwani',
                'priceFormatted' => '৳ 42,000',
                'fabric' => 'Raw Mulberry Silk • Heirloom Karchupi',
                'desc' => 'Royal bridal sherwani hand-embroidered over 120 hours with antique dabka, nakshi, and tonal silk threads.',
                'image' => 'https://images.unsplash.com/photo-1617137968427-85924c800a22?auto=format&fit=crop&w=650&q=80',
                'imageLarge' => 'https://images.unsplash.com/photo-1617137968427-85924c800a22?auto=format&fit=crop&w=900&q=80',
                'fallback' => 'https://images.unsplash.com/photo-1617137968427-85924c800a22?auto=format&fit=crop&w=650&q=80',
                'url' => url('products'),
                'hasVariations' => false,
                'addToCartUrl' => '',
            ],
            [
                'id' => 'wb-m5',
                'productId' => 0,
                'name' => 'Royal Midnight Velvet Tuxedo',
                'group' => 'tuxedos',
                'category' => 'Tuxedos',
                'priceFormatted' => '৳ 28,000',
                'fabric' => 'Como Silk Velvet • Satin Peak Lapel',
                'desc' => 'Luminous midnight-pile silk velvet evening jacket tailored with silk grosgrain peak lapels.',
                'image' => 'https://images.unsplash.com/photo-1555069519-127aadedf1ee?auto=format&fit=crop&w=650&q=80',
                'imageLarge' => 'https://images.unsplash.com/photo-1555069519-127aadedf1ee?auto=format&fit=crop&w=900&q=80',
                'fallback' => 'https://images.unsplash.com/photo-1555069519-127aadedf1ee?auto=format&fit=crop&w=650&q=80',
                'url' => url('products'),
                'hasVariations' => false,
                'addToCartUrl' => '',
            ],
            [
                'id' => 'wb-m6',
                'productId' => 0,
                'name' => 'Heritage Navy Bandhgala Suit',
                'group' => 'suits',
                'category' => 'Suits',
                'priceFormatted' => '৳ 22,000',
                'fabric' => 'Tropical Worsted Wool • Brass Buttons',
                'desc' => 'Refined regal Bandhgala tailored for formal receptions, featuring hand-crafted antique brass buttons.',
                'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=650&q=80',
                'imageLarge' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=900&q=80',
                'fallback' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=650&q=80',
                'url' => url('products'),
                'hasVariations' => false,
                'addToCartUrl' => '',
            ],
        ];
    }
@endphp

<section id="masterpieces" class="wb-section wb-section--travertine wb-masterpieces">
    <div class="container">
        <div class="wb-masterpieces__top">
            <div>
                <p class="wb-eyebrow wb-eyebrow--brass">{{ __('Ready & Made-to-Measure') }}</p>
                <h2 class="wb-section-title">
                    CURATED <span class="wb-italic">MASTERPIECES</span>
                </h2>
            </div>

            {{-- Horizontally Scrollable Filter Pills --}}
            <div id="wb-filter-bar" class="wb-filter-bar" role="tablist" aria-label="{{ __('Filter Masterpieces') }}">
                <button type="button" data-wb-filter="all" onclick="window.filterAtelierProducts('all')" class="wb-cat-pill is-active">{{ __('All') }}</button>
                <button type="button" data-wb-filter="sherwani" onclick="window.filterAtelierProducts('sherwani')" class="wb-cat-pill">{{ __('Sherwani') }}</button>
                <button type="button" data-wb-filter="suits" onclick="window.filterAtelierProducts('suits')" class="wb-cat-pill">{{ __('Suits') }}</button>
                <button type="button" data-wb-filter="gurkha" onclick="window.filterAtelierProducts('gurkha')" class="wb-cat-pill">{{ __('Gurkha') }}</button>
                <button type="button" data-wb-filter="tuxedos" onclick="window.filterAtelierProducts('tuxedos')" class="wb-cat-pill">{{ __('Tuxedos') }}</button>
            </div>
        </div>

        {{-- Responsive 2-Col Mobile / 4-Col Desktop Product Grid --}}
        <div id="wb-product-grid" class="wb-product-grid">
            @foreach ($catalogItems as $item)
                <article
                    data-wb-group="{{ $item['group'] }}"
                    onclick="window.openAtelierQuickView('{{ $item['id'] }}')"
                    class="wb-prod-card"
                    role="button"
                    tabindex="0"
                    onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();this.click();}"
                >
                    <div>
                        <div class="wb-prod-card__media">
                            <img
                                src="{{ $item['image'] }}"
                                alt="{{ $item['name'] }}"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ $item['fallback'] }}';"
                            />
                        </div>
                        <p class="wb-prod-card__cat">{{ $item['category'] }}</p>
                        <h3 class="wb-prod-card__title">{{ $item['name'] }}</h3>
                    </div>
                    <div class="wb-prod-card__foot">
                        <span class="wb-prod-card__price">{{ $item['priceFormatted'] }}</span>
                        <span class="wb-prod-card__plus" aria-hidden="true">+</span>
                    </div>
                </article>
            @endforeach
        </div>

        @if (is_plugin_active('ecommerce'))
            <div class="wb-masterpieces__more">
                <a href="{{ route('public.products') }}" class="wb-btn-outline-dark">
                    {{ __('Explore Complete Archive') }} &rarr;
                </a>
            </div>
        @endif
    </div>

    <script>
        window.ATELIER_MASTERPIECES = @json($catalogItems);
    </script>
</section>
