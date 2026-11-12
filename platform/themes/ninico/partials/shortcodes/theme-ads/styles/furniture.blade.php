<section class="banner-area pb-20">
    <div class="container">
        <div class="row">
            @if($ad = $ads->first())
                <div class="col-xl-6 col-lg-12 col-md-12">
                    <div class="tpbanneritems p-relative">
                        <div class="tpbanneritem__thumb mb-20">
                            <img src="{{ RvMedia::getImageUrl($ad->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $ad->name }}">
                            <div class="tpbanneritem__content">
                                @if($subtitle = $ad->getMetaData('subtitle', true))
                                    <p>{!! BaseHelper::clean($subtitle) !!}</p>
                                @endif
                                @if($name = $ad->name)
                                    <h5 class="tpbanneritem__title mb-60">
                                        <a href="{{ $ad->url }}">
                                            {!! BaseHelper::clean($name) !!}
                                        </a>
                                    </h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($ads->count() > 1)
                <div class="col-xl-6 col-lg-12 col-md-12">
                    <div class="tpbanneritem">
                        <div class="row">
                            @foreach($ads->skip(1) as $ad)
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="tpbanneritem__thumb banner-animation p-relative">
                                        <img src="{{ RvMedia::getImageUrl($ad->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $ad->name }}">
                                        <div class="tpbanneritem__text">
                                            @if($name = $ad->name)
                                                <h5 class="tpbanneritem__text-title">
                                                    <a href="{{ $ad->url }}">{!! BaseHelper::clean($name) !!}</a>
                                                </h5>
                                            @endif
                                            @if($subtitle = $ad->getMetaData('subtitle', true))
                                                <h3 class="tpbanneritem__text-price">{!! BaseHelper::clean($subtitle) !!}</h3>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
