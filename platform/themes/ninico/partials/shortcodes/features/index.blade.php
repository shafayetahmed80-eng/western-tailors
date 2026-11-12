<section class="feature-area pt-70 pb-10">
    @foreach(range(1, $quantity) as $i)
        <div class="row align-items-center">
            @if($loop->odd)
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="tpfeature__inner-thumb mb-70">
                        <img src="{{ RvMedia::getImageUrl($shortcode->{'image_' . $i}, default: RvMedia::getDefaultImage()) }}" alt="{{ $shortcode->{'title_' . $i} }}">
                    </div>
                </div>
            @endif
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div @class(['tpabout__inner-title-area about-inner-content mb-70', 'ml-50 mr-50' => $loop->odd, 'mr-100' => $loop->even])>
                    @if($subtitle = $shortcode->{'subtitle_' . $i})
                        <h4 class="tpabout__inner-sub-title mb-5">{!! BaseHelper::clean($subtitle) !!}</h4>
                    @endif
                    @if($title = $shortcode->{'title_' . $i})
                        <h4 class="tpabout__inner-title mb-25">{{ $title }}</h4>
                    @endif
                    @if($description = $shortcode->{'description_' . $i})
                        <p>{!! BaseHelper::clean($description) !!}</p>
                    @endif
                    @if($buttonLabel = $shortcode->{'button_label_' . $i})
                        <a class="tpteam__btn" href="{{ $shortcode->{'button_url_' . $i} }}">{{ $buttonLabel }}</a>
                    @endif
                </div>
            </div>
            @if($loop->even)
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="tpfeature__inner-thumb mb-70">
                        <img src="{{ RvMedia::getImageUrl($shortcode->{'image_' . $i}, default: RvMedia::getDefaultImage()) }}" alt="{{ $shortcode->{'title_' . $i} }}">
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</section>
