@php
    $catRecords = collect();
    if (is_plugin_active('ecommerce')) {
        $catRecords = \Botble\Ecommerce\Models\ProductCategory::query()
            ->whereIn('id', [41, 39, 38, 72, 26, 21, 33, 32, 19])
            ->with('slugable')
            ->get()
            ->keyBy('id');
    }

    $resolveImg = function (array $catIds, string $fallbackUrl) use ($catRecords): string {
        foreach ($catIds as $cid) {
            $cat = $catRecords->get($cid);
            if ($cat && ! empty($cat->image)) {
                return RvMedia::getImageUrl($cat->image, null, false, $fallbackUrl);
            }
        }
        return $fallbackUrl;
    };

    $resolveUrl = function (array $catIds) use ($catRecords): string {
        foreach ($catIds as $cid) {
            $cat = $catRecords->get($cid);
            if ($cat && ! empty($cat->url)) {
                return $cat->url;
            }
        }
        return url('products');
    };

    $editions = [
        [
            'num' => '01',
            'filter' => 'sherwani',
            'badge' => 'Royal Couture',
            'title' => 'Wedding Sherwani',
            'subtitle' => 'Heirloom Zardozi',
            'image' => $resolveImg([41, 39, 38], 'https://images.unsplash.com/photo-1617137968427-85924c800a22?auto=format&fit=crop&w=600&q=80'),
            'fallback' => 'https://images.unsplash.com/photo-1617137968427-85924c800a22?auto=format&fit=crop&w=600&q=80',
            'url' => $resolveUrl([38, 39, 41]),
        ],
        [
            'num' => '02',
            'filter' => 'suits',
            'badge' => 'Full Canvas',
            'title' => 'Bespoke Suits',
            'subtitle' => 'Savile Row Cut',
            'image' => $resolveImg([72, 26, 21], 'https://images.unsplash.com/photo-1593030761757-71fae45fa0e7?auto=format&fit=crop&w=600&q=80'),
            'fallback' => 'https://images.unsplash.com/photo-1593030761757-71fae45fa0e7?auto=format&fit=crop&w=600&q=80',
            'url' => $resolveUrl([72, 21, 26]),
        ],
        [
            'num' => '03',
            'filter' => 'gurkha',
            'badge' => 'Signature Waist',
            'title' => 'Gurkha Trousers',
            'subtitle' => 'Double Pleated',
            'image' => $resolveImg([33, 32], 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?auto=format&fit=crop&w=600&q=80'),
            'fallback' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?auto=format&fit=crop&w=600&q=80',
            'url' => $resolveUrl([33, 32]),
        ],
        [
            'num' => '04',
            'filter' => 'tuxedos',
            'badge' => 'Black Tie',
            'title' => 'Royal Tuxedos',
            'subtitle' => 'Midnight Velvet',
            'image' => $resolveImg([19], 'https://images.unsplash.com/photo-1555069519-127aadedf1ee?auto=format&fit=crop&w=600&q=80'),
            'fallback' => 'https://images.unsplash.com/photo-1555069519-127aadedf1ee?auto=format&fit=crop&w=600&q=80',
            'url' => $resolveUrl([19]),
        ],
    ];
@endphp

<section id="archive" class="wb-section wb-section--travertine wb-archive">
    <div class="container">
        <div class="wb-section-head">
            <div>
                <p class="wb-eyebrow wb-eyebrow--brass">{{ __('Signature Editions') }}</p>
                <h2 class="wb-section-title">
                    THE ATELIER <span class="wb-italic">ARCHIVE</span>
                </h2>
            </div>
            <span class="wb-swipe-hint d-lg-none">
                {{ __('Swipe') }} <span>&rarr;</span>
            </span>
            <a href="{{ is_plugin_active('ecommerce') ? route('public.products') : url('products') }}" class="wb-archive__view-all d-none d-lg-inline-flex">
                {{ __('View Full Catalog') }} &rarr;
            </a>
        </div>

        <div class="wb-archive-track">
            @foreach ($editions as $ed)
                <article
                    onclick="window.selectAtelierCategory ? window.selectAtelierCategory('{{ $ed['filter'] }}') : (window.location.href = '{{ $ed['url'] }}')"
                    class="wb-archive-card"
                    role="button"
                    tabindex="0"
                    onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();this.click();}"
                >
                    <div class="wb-archive-card__media">
                        <img
                            src="{{ $ed['image'] }}"
                            alt="{{ $ed['num'] }} {{ $ed['title'] }}"
                            loading="lazy"
                            onerror="this.onerror=null;this.src='{{ $ed['fallback'] }}';"
                        />
                        <span class="wb-archive-card__badge">{{ $ed['badge'] }}</span>
                    </div>
                    <div class="wb-archive-card__foot">
                        <div class="wb-archive-card__meta">
                            <span class="wb-archive-card__num">{{ $ed['num'] }}</span>
                            <div>
                                <h3 class="wb-archive-card__title">{{ $ed['title'] }}</h3>
                                <p class="wb-archive-card__sub">{{ $ed['subtitle'] }}</p>
                            </div>
                        </div>
                        <span class="wb-archive-card__arrow">&rarr;</span>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
