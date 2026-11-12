@php
    $hasAds = $shortcode->ads_1 || $shortcode->ads_2;
    $style = ! in_array($shortcode->style, ['wooden', 'fashion', 'furniture', 'cosmetics', 'grocery', 'full-width']) ? 'wooden' : $shortcode->style;
@endphp

@if($sliders->isNotEmpty())
    @php $sliders->loadMissing('metadata'); @endphp
    <section @class([
        'slider-area',
        'pb-25' => $style === 'wooden',
        'slider-bg slider-bg-height' => $style === 'fashion',
    ]) @if ($shortcode->background_color) style="background-color: {{ $shortcode->background_color }} !important;" @endif>
        @include(Theme::getThemeNamespace("partials.shortcodes.simple-slider.styles.$style"))
    </section>
@endif
