@php
    $eyebrow = $shortcode->eyebrow ?: 'Dhaka Atelier • Est. Heritage';
    $editionBadge = $shortcode->edition_badge ?: '2026 Edit';
    $subtitle = $shortcode->subtitle ?: 'Savile Row Precision Meets Royal Heritage — Hand-cut bespoke suits & heirloom couture.';
    $sliderKey = trim((string) ($shortcode->slider_key ?: 'slider-home-1'));
    $defaultEditorialImg = 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1400&q=85';

    $fallbackImg = $defaultEditorialImg;
    if (! empty($shortcode->background_image)) {
        $fallbackImg = RvMedia::getImageUrl($shortcode->background_image, null, false, $defaultEditorialImg);
    } elseif (file_exists(public_path('storage/slider-home-final/371e9f0d-2b51-4537-8346-f21110ec0073.webp'))) {
        $fallbackImg = asset('storage/slider-home-final/371e9f0d-2b51-4537-8346-f21110ec0073.webp');
    }

    $heroSlides = [];
    if (is_plugin_active('simple-slider') && class_exists(\Botble\SimpleSlider\Models\SimpleSlider::class)) {
        $simpleSlider = \Botble\SimpleSlider\Models\SimpleSlider::query()
            ->where('key', $sliderKey)
            ->wherePublished()
            ->with(['publishedSliderItems' => function ($query): void {
                $query->orderBy('order');
            }])
            ->first();

        if ($simpleSlider && $simpleSlider->publishedSliderItems->isNotEmpty()) {
            foreach ($simpleSlider->publishedSliderItems as $item) {
                $cleanTitle = trim((string) preg_replace(
                    '/\s+/',
                    ' ',
                    strip_tags(str_ireplace(['<br>', '<br/>', '<br />'], ' ', (string) $item->title))
                ));
                $cleanDesc = trim(strip_tags((string) $item->description));
                $rawLink = trim((string) $item->link);
                $safeLink = '';
                if ($rawLink !== '' && (str_starts_with($rawLink, '/') || str_starts_with($rawLink, 'http://') || str_starts_with($rawLink, 'https://'))) {
                    $safeLink = $rawLink;
                }

                $heroSlides[] = [
                    'image' => $item->image ? RvMedia::getImageUrl($item->image, null, false, $fallbackImg) : $fallbackImg,
                    'title' => $cleanTitle ?: __('Western Bespoke Royal Tailoring'),
                    'eyebrow' => $cleanDesc,
                    'link' => $safeLink ?: url('products'),
                ];
            }
        }
    }

    if ($heroSlides === []) {
        $heroSlides[] = [
            'image' => $fallbackImg,
            'title' => __('Western Bespoke Royal Tailoring'),
            'eyebrow' => '',
            'link' => url('products'),
        ];
    }

    $hasMultipleSlides = count($heroSlides) > 1;
    $firstSlide = $heroSlides[0];
@endphp

<section id="hero" class="wb-hero" @if ($hasMultipleSlides) data-wb-hero-slider @endif>
    <div class="wb-hero__slides" aria-hidden="true">
        @foreach ($heroSlides as $idx => $slide)
            <div
                class="wb-hero__slide {{ $idx === 0 ? 'is-active' : '' }}"
                data-wb-slide-index="{{ $idx }}"
                data-wb-slide-title="{{ $slide['title'] }}"
                data-wb-slide-eyebrow="{{ $slide['eyebrow'] }}"
                data-wb-slide-link="{{ $slide['link'] }}"
            >
                <img
                    src="{{ $slide['image'] }}"
                    alt="{{ $slide['title'] }}"
                    class="wb-hero__bg"
                    loading="{{ $idx === 0 ? 'eager' : 'lazy' }}"
                    onerror="this.onerror=null;this.src='{{ $defaultEditorialImg }}';"
                />
            </div>
        @endforeach
    </div>
    <div class="wb-hero__scrim-top"></div>
    <div class="wb-hero__scrim-bottom"></div>

    <div class="container wb-hero__container">
        {{-- Top Atelier Edition Bar --}}
        <div class="wb-hero__top">
            <span class="wb-hero__eyebrow">
                <span class="wb-hero__line"></span>
                {{ $eyebrow }}
            </span>
            <span class="wb-hero__pill">{{ $editionBadge }}</span>
        </div>

        {{-- Bottom Editorial Headline & CTAs --}}
        <div class="wb-hero__bottom">
            <h1 class="wb-hero__title">
                THE ART OF <br />
                <span class="wb-italic-brass">ROYAL</span> TAILORING
            </h1>
            <p class="wb-hero__subtitle">
                {{ $subtitle }}
            </p>

            <div class="wb-hero__actions">
                <button
                    type="button"
                    onclick="window.openAtelierFitting && window.openAtelierFitting('Charcoal Double-Breasted Suit')"
                    class="wb-btn-brass wb-hero__primary-cta"
                >
                    {{ __('Book Private Fitting') }}
                </button>

                <button
                    type="button"
                    onclick="window.openAtelierFilm && window.openAtelierFilm()"
                    class="wb-film-pill"
                >
                    <span class="wb-film-pill__icon">
                        <svg width="10" height="10" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5.14v14l11-7-11-7z"/>
                        </svg>
                    </span>
                    <span>{{ __('Watch Atelier Film') }}</span>
                </button>
            </div>

            @if ($hasMultipleSlides)
                <div class="wb-hero__slider-bar" aria-label="{{ __('Featured lookbook slides') }}">
                    <a id="wb-hero-caption-link" href="{{ $firstSlide['link'] }}" class="wb-hero__slide-meta">
                        <span id="wb-hero-counter" class="wb-hero__slide-counter">01 / {{ str_pad((string) count($heroSlides), 2, '0', STR_PAD_LEFT) }}</span>
                        <span id="wb-hero-caption" class="wb-hero__slide-caption">{{ $firstSlide['title'] }}</span>
                    </a>

                    <div class="wb-hero__slider-controls">
                        <div class="wb-hero__dots" role="tablist" aria-label="{{ __('Hero slide pagination') }}">
                            @foreach ($heroSlides as $idx => $slide)
                                <button
                                    type="button"
                                    class="wb-hero__dot {{ $idx === 0 ? 'is-active' : '' }}"
                                    data-wb-slide-dot="{{ $idx }}"
                                    aria-label="{{ __('Show slide :num: :title', ['num' => $idx + 1, 'title' => $slide['title']]) }}"
                                ></button>
                            @endforeach
                        </div>
                        <div class="wb-hero__arrows">
                            <button type="button" class="wb-hero__arrow" data-wb-slide-prev aria-label="{{ __('Previous slide') }}">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            </button>
                            <button type="button" class="wb-hero__arrow" data-wb-slide-next aria-label="{{ __('Next slide') }}">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
