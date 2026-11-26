@php
    $isHome = request()->is('/') || request()->routeIs('public.index');
    $catMap = collect();
    if (is_plugin_active('ecommerce')) {
        $catMap = \Botble\Ecommerce\Models\ProductCategory::query()
            ->whereIn('id', [38, 72, 21, 33, 19])
            ->with('slugable')
            ->get()
            ->keyBy('id');
    }
    $sherwaniUrl = optional($catMap->get(38))->url ?: url('products');
    $suitsUrl = optional($catMap->get(72) ?: $catMap->get(21))->url ?: url('products');
    $gurkhaUrl = optional($catMap->get(33))->url ?: url('products');
    $tuxedoUrl = optional($catMap->get(19))->url ?: url('products');
    $rawPhone = theme_option('whatsapp_number') ?: theme_option('hotline', '8801700000000');
    $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone) ?: '8801700000000';
@endphp

<footer class="wb-monumental-footer">
    <div class="container">
        <div class="wb-footer__grid">
            {{-- Newsletter Column --}}
            <div class="wb-footer__newsletter">
                <p class="wb-eyebrow">{{ __('The Private Archive') }}</p>
                <p class="wb-footer__lead">
                    {{ __('Receive invitations to private trunk shows & seasonal Italian mill releases.') }}
                </p>
                <form id="wb-newsletter-form" class="wb-newsletter-form" novalidate>
                    @csrf
                    <input
                        id="wb-newsletter-email"
                        name="email"
                        type="email"
                        required
                        placeholder="{{ __('Your email address') }}"
                        class="wb-newsletter-form__input"
                        aria-label="{{ __('Your email address') }}"
                    />
                    <button type="submit" class="wb-newsletter-form__btn">
                        {{ __('Join') }} &rarr;
                    </button>
                </form>
            </div>

            {{-- Collections Links --}}
            <div class="wb-footer__col">
                <p class="wb-footer__heading">{{ __('Collections') }}</p>
                <ul class="wb-footer__links">
                    <li><a href="{{ $sherwaniUrl }}" @if($isHome) data-wb-cat="sherwani" @endif>{{ __('Wedding Sherwani') }}</a></li>
                    <li><a href="{{ $suitsUrl }}" @if($isHome) data-wb-cat="suits" @endif>{{ __('Bespoke Suits') }}</a></li>
                    <li><a href="{{ $gurkhaUrl }}" @if($isHome) data-wb-cat="gurkha" @endif>{{ __('Gurkha Trousers') }}</a></li>
                    <li><a href="{{ $tuxedoUrl }}" @if($isHome) data-wb-cat="tuxedos" @endif>{{ __('Royal Tuxedos') }}</a></li>
                    @if (is_plugin_active('ecommerce'))
                        <li><a href="{{ route('public.products') }}">{{ __('All Masterpieces') }}</a></li>
                    @endif
                </ul>
            </div>

            {{-- House Links --}}
            <div class="wb-footer__col">
                <p class="wb-footer__heading">{{ __('House') }}</p>
                <ul class="wb-footer__links">
                    <li><a href="{{ $isHome ? '#crafted' : BaseHelper::getHomepageUrl() . '#crafted' }}" @if($isHome) data-wb-scroll="crafted" @endif>{{ __('Our Craft') }}</a></li>
                    <li><button type="button" onclick="window.openAtelierFilm && window.openAtelierFilm()">{{ __('Atelier Film') }}</button></li>
                    <li><button type="button" onclick="window.openAtelierFitting && window.openAtelierFitting('Private Home Measurement')">{{ __('Home Fitting') }}</button></li>
                    <li><a href="{{ url('contact') }}">{{ __('Contact & Salons') }}</a></li>
                    <li class="wb-footer__copy">&copy; {{ date('Y') }} {{ __('Dhaka') }}</li>
                </ul>
            </div>

            {{-- Dhaka Salons Column (Desktop & Tablet) --}}
            <div class="wb-footer__col wb-footer__col--salon d-none d-md-block">
                <p class="wb-footer__heading">{{ __('Dhaka Salons') }}</p>
                <p class="wb-footer__salon-text">
                    {{ __('Banani & Dhanmondi') }}<br>
                    {{ __('Sat – Thu • 11:00 AM – 9:00 PM') }}
                </p>
                <a
                    href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('Hello Western Bespoke Atelier, I would like to inquire about a private fitting appointment.') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="wb-footer__wa-link"
                >
                    {{ __('WhatsApp Concierge') }} &rarr;
                </a>
            </div>
        </div>
    </div>

    {{-- Edge-to-Edge Oversized Subtle Serif Wordmark --}}
    <div class="wb-footer__wordmark-wrap" aria-hidden="true">
        <p class="wb-footer__wordmark">WESTERN BESPOKE</p>
    </div>
</footer>
