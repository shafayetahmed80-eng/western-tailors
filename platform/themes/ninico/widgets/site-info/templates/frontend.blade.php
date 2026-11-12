<div class="col-lg-3 col-md-4 col-sm-6">
    <div class="footer-widget footer-col-1 mb-40">
        <div class="footer-logo mb-30">
            @if ($logo = Theme::get('footerLogo', $config['logo']))
                <a href="{{ BaseHelper::getHomepageUrl() }}">
                    {!! Theme::getLogoImage([], 'logo', 35, $logo) !!}
                </a>
            @endif
        </div>

        @if ($description = $config['description'])
            <div class="footer-content">
                <div>{!! BaseHelper::clean($description) !!}</div>
            </div>
        @endif
    </div>
</div>
