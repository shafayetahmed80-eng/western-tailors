<div class="col-xl-6 col-lg-8 col-md-8 col-sm-6">
    <div class="footer-cta__source">
        <div class="footer-cta__source-content">
            @if($title = Arr::get($config, 'title'))
                <h4 class="footer-cta__source-title">{!! BaseHelper::clean($title) !!}</h4>
            @endif
            @if($subtitle = Arr::get($config, 'subtitle'))
                <p>{!! BaseHelper::clean($subtitle) !!}</p>
            @endif
        </div>
        <div class="footer-cta__source-thumb">
            @if ($iosLink = Arr::get($config, 'ios_link'))
                <a href="{{ $iosLink }}">
                    <img src="{{ RvMedia::getImageUrl(Arr::get($config, 'ios_image')) }}" alt="apple">
                </a>
            @endif

            @if ($androidLink = Arr::get($config, 'android_link'))
                <a href="{{ $androidLink }}">
                    <img src="{{ RvMedia::getImageUrl(Arr::get($config, 'android_image')) }}" alt="google">
                </a>
            @endif
        </div>
    </div>
</div>
