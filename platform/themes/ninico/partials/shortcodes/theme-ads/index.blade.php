@php
    $ads = \Botble\Ads\Models\Ads::query()
        ->whereIn('key', [$shortcode->key_1, $shortcode->key_2, $shortcode->key_3])
        ->wherePublished()
        ->get();

    $style = ! in_array($shortcode->style, ['fashion', 'furniture']) ? 'fashion' : $shortcode->style;
@endphp

@include(Theme::getThemeNamespace("partials.shortcodes.theme-ads.styles.$style"))
