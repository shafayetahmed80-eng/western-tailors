@php
    $eyebrow = $shortcode->eyebrow ?: 'Dhaka Atelier • Est. Heritage';
    $editionBadge = $shortcode->edition_badge ?: '2026 Edit';
    $subtitle = $shortcode->subtitle ?: 'Savile Row Precision Meets Royal Heritage — Hand-cut bespoke suits & heirloom couture.';
    $defaultEditorialImg = 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1400&q=85';

    if (! empty($shortcode->background_image)) {
        $heroImg = RvMedia::getImageUrl($shortcode->background_image, null, false, $defaultEditorialImg);
    } elseif (file_exists(public_path('storage/slider-home-final/371e9f0d-2b51-4537-8346-f21110ec0073.webp'))) {
        $heroImg = asset('storage/slider-home-final/371e9f0d-2b51-4537-8346-f21110ec0073.webp');
    } else {
        $heroImg = $defaultEditorialImg;
    }
@endphp

<section id="hero" class="wb-hero">
    <img
        src="{{ $heroImg }}"
        alt="{{ __('Western Bespoke Royal Tailoring') }}"
        class="wb-hero__bg"
        onerror="this.onerror=null;this.src='{{ $defaultEditorialImg }}';"
    />
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
        </div>
    </div>
</section>
