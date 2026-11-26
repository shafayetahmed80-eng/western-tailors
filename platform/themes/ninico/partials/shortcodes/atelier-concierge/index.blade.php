@php
    $rawPhone = theme_option('whatsapp_number') ?: theme_option('hotline', '8801700000000');
    $cleanPhone = preg_replace('/[^0-9]/', '', (string) $rawPhone) ?: '8801700000000';
    $waLink = 'https://wa.me/' . $cleanPhone . '?text=' . rawurlencode('Hello Western Bespoke Atelier, I would like to schedule a private salon or home measurement appointment in Dhaka.');
@endphp

<section id="concierge" class="wb-concierge-wrap">
    <div class="container">
        <div class="wb-concierge-card">
            <div class="wb-concierge-card__glow" aria-hidden="true"></div>

            <div class="wb-concierge-card__content">
                <div>
                    <p class="wb-eyebrow mb-1">{{ __('Dhaka Atelier Concierge') }}</p>
                    <h3 class="wb-concierge-card__title">{{ __('Banani & Dhanmondi') }}</h3>
                    <p class="wb-concierge-card__desc">
                        {{ __('Private salon appointments & home measurement service across Dhaka.') }}<br>
                        {{ __('Sat – Thu • 11:00 AM – 9:00 PM') }}
                    </p>
                </div>

                <div class="wb-concierge-card__actions">
                    <button
                        type="button"
                        onclick="window.openAtelierFitting && window.openAtelierFitting('Full Wardrobe Consultation')"
                        class="wb-btn-brass"
                    >
                        {{ __('Book Salon') }}
                    </button>
                    <a
                        href="{{ $waLink }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="wb-btn-outline-brass"
                    >
                        <span>{{ __('WhatsApp') }}</span>
                        <span class="wb-brass-text">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
