@if ($config['image'])
    <div class="col-xl-6 col-lg-5 col-md-7 col-sm-12">
        <div class="footer-copyright__brand">
            @if($url = $config['url'])
                <a href="{{ $url }}">
                    {{ RvMedia::image($config['image'], theme_option('site_title')) }}
                </a>
            @else
                {{ RvMedia::image($config['image'], theme_option('site_title')) }}
            @endif
        </div>
    </div>
@endif
