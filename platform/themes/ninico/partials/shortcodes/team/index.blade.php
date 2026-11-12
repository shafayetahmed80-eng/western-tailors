<section class="team-area grey-bg-3 pb-30">
    <div class="row">
        <div class="col-sm-12">
            <div class="tpabout__inner-title-area mt-65 mb-45 text-center">
                @if($subtitle = $shortcode->subtitle)
                    <h4 class="tpabout__inner-sub-title">{!! BaseHelper::clean($subtitle) !!}</h4>
                @endif
                @if($title = $shortcode->title)
                    <h4 class="tpabout__inner-title">{!! BaseHelper::clean($title) !!}</h4>
                @endif
            </div>
        </div>
    </div>
    <div class="swiper-container tp-team-active">
        <div class="swiper-wrapper">
            @foreach($teams as $team)
                <div class="swiper-slide">
                    <div class="tpteam__item p-relative mb-40">
                        <div class="tpteam__thumb">
                            <img src="{{ RvMedia::getImageUrl($team->photo, default: RvMedia::getDefaultImage()) }}" alt="{{ $team->name }}">
                        </div>
                        <div class="tpteam__content">
                            <h4 class="tpteam__position">{{ $team->title }}</h4>
                            <h5 class="tpteam__title">{{ $team->name }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
