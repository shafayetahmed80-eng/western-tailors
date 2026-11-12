<section class="services-area pt-70 pb-20">
    <div class="container">
        <div class="row services-gx-item">
            @foreach(range(1, $shortcode->quantity) as $i)
                <div class="col-lg-3 col-sm-6">
                    @php
                        $url = $shortcode->{"url_$i"};
                    @endphp

                    <{{ $url ? 'a' : 'div' }} @if($url) href="{{ $shortcode->{"url_$i"} }}" @endif class="tpservicesitem d-flex align-items-center mb-30">
                        <div class="tpservicesitem__icon mr-20">
                            <img src="{{ RvMedia::getImageUrl($shortcode->{"image_$i"}) }}" alt="{{ $shortcode->{"title_$i"} }}">
                        </div>
                        <div class="tpservicesitem__content">
                            <h4 class="tpservicesitem__title">{{ $shortcode->{"title_$i"} }}</h4>
                            <p>{{ $shortcode->{"description_$i"} }}</p>
                        </div>
                    </{{ $url ? 'a' : 'div' }}>
                </div>
            @endforeach
        </div>
    </div>
</section>
