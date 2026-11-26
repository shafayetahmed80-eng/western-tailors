@php
    $filmImg = RvMedia::getImageUrl('slider-home-final/445cf742-ac98-4125-831a-0eb539cf7019.webp', null, false, 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?auto=format&fit=crop&w=800&q=80');
@endphp

{{-- Atelier Editorial Film Modal --}}
<div id="wb-film-backdrop" class="wb-film-backdrop" hidden aria-hidden="true">
    <div class="wb-film-card" role="dialog" aria-modal="true" aria-labelledby="wb-film-title">
        <button type="button" onclick="window.closeAtelierFilm && window.closeAtelierFilm()" aria-label="{{ __('Close Film') }}" class="wb-film-card__close">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="wb-film-card__stage">
            <img
                src="{{ $filmImg }}"
                alt="{{ __('Western Bespoke Atelier Craft') }}"
                class="wb-film-card__img"
                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1598033129183-c4f50c736f10?auto=format&fit=crop&w=800&q=80';"
            />
            <div class="wb-film-card__overlay"></div>

            <div class="wb-film-card__content">
                <p class="wb-eyebrow mb-1">{{ __('Atelier Film') }} &bull; {{ __('Chapter I') }}</p>
                <h3 id="wb-film-title" class="wb-film-card__title">
                    {{ __('The Silence of') }} <span class="wb-italic-brass">{{ __('Hand-Stitched') }}</span> {{ __('Canvas') }}
                </h3>
                <p class="wb-film-card__desc">
                    {{ __('Every lapel pad-stitched by hand, every Zardozi motif sketched on parchment in our Dhaka house.') }}
                </p>
                <div class="wb-film-progress">
                    <div class="wb-film-progress__bar"></div>
                </div>
                <button
                    type="button"
                    onclick="window.closeAtelierFilm && window.closeAtelierFilm(); window.openAtelierFitting && window.openAtelierFitting('Charcoal Double-Breasted Suit');"
                    class="wb-btn-brass w-100"
                >
                    {{ __('Book Private Experience') }}
                </button>
            </div>
        </div>
    </div>
</div>
