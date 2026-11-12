@php
    $footerColor = Theme::get('footerColor');
@endphp

<footer>
    <div
        class="footer-area pt-65"
        style="
            background-color: {{ Theme::get('footerBackgroundColor') ?: theme_option('footer_background_color', '#F8F8F8') }};
            --footer-text-color: {{ Theme::get('footerTextColor') ?: theme_option('footer_text_color', '#000000') }};
            --footer-text-muted-color: {{ Theme::get('footerTextMutedColor') ?: theme_option('footer_text_muted_color', '#686666') }};
            --footer-border-color: {{ Theme::get('footerBorderColor') ?: theme_option('footer_border_color', '#E0E0E0') }};
        "
    >
        <div class="container">
            <div class="main-footer pb-15 mb-30">
                <div class="row">
                    {!! dynamic_sidebar('footer_sidebar') !!}
                </div>
            </div>
            <div class="footer-cta pb-20">
                <div class="row justify-content-between align-items-center">
                    {!! dynamic_sidebar('footer_middle_sidebar') !!}
                </div>
            </div>
        </div>
        <div class="footer-copyright" style="background-color: {{ Theme::get('footerBottomBackgroundColor') ?: theme_option('footer_bottom_background_color', '#ededed') }}">
            <div class="container">
                <div class="row">
                    {!! dynamic_sidebar('footer_bottom_sidebar') !!}
                </div>
            </div>
        </div>
    </div>
</footer>
