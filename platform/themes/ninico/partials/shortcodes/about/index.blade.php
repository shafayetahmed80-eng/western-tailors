<section class="about-area">
    <div class="tpabout__inner-logo p-relative">
        <div class="row">
            <div class="col-lg-6">
                <div class="tpabout__inner-thumb mb-40">
                    <img src="{{ RvMedia::getImageUrl($shortcode->image_1, default: RvMedia::getDefaultImage()) }}" alt="{{ $shortcode->title }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="tpabout__inner-thumb mb-40">
                    <img src="{{ RvMedia::getImageUrl($shortcode->image_2, default: RvMedia::getDefaultImage()) }}" alt="{{ $shortcode->title }}">
                </div>
            </div>
        </div>
        @if($logo = $shortcode->logo)
            <div class="tpabout__logo">
                <a href="{{ BaseHelper::getHomepageUrl() }}">
                    <img src="{{ RvMedia::getImageUrl($logo, default: RvMedia::getDefaultImage()) }}" alt="{{ $shortcode->title }}">
                </a>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="tpabout__inner-title-area mt-25 mb-45">
                @if($subtitle = $shortcode->subtitle)
                    <h4 class="tpabout__inner-sub-title">{!! BaseHelper::clean($subtitle) !!}</h4>
                @endif
                @if($title = $shortcode->title)
                    <h4 class="tpabout__inner-title">{!! BaseHelper::clean($title) !!}</h4>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
            <div class="tpabout__inner-story mb-40">
                <p>{!! BaseHelper::clean($shortcode->story_text_1) !!}</p>
            </div>
        </div>
        <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
            <div class="tpabout__inner-story-2 mb-40">
                <p>{!! BaseHelper::clean($shortcode->story_text_2) !!}</p>
            </div>
        </div>
        <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12">
            <div class="tpabout__inner-list mb-40">
                <ul>
                    @foreach(range(1, 5) as $i)
                        @if($text = $shortcode->{'list_item_' . $i})
                            <li>
                                <a href="{{ $shortcode->{'list_item_url_' . $i} ?? 'javascript:void(0)' }}">
                                    <i class="fal fa-check"></i>
                                    {{ $text }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
