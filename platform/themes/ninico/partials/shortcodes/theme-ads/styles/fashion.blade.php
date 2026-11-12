<section class="exclusive-area pb-65">
    <div class="container">
        <div class="row">
            @foreach($ads as $ad)
                <div @class(['col-lg-8 col-md-8' => $loop->first, 'col-lg-4 col-md-4' => $loop->index === 1])>
                    <a href="{{ $ad->url }}" @class(['d-block banner-animation p-relative mb-30', 'exclusiveitem' => $loop->first, 'exclusivearea' => $loop->index === 1])>
                        <div @class(['exclusiveitem__thumb' => $loop->first, 'exclusivearea__thumb' => $loop->index === 1])>
                            <img src="{{ RvMedia::getImageUrl($ad->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $ad->name }}">
                        </div>
                        <div @class(['tpexclusive__content' => $loop->first, 'tpexclusive__contentarea text-center' => $loop->index === 1])>
                            @php($subtitle = $ad->getMetaData('subtitle', true))

                            @if($subtitle && $loop->first)
                                <h4 class="tpexclusive__subtitle">{!! BaseHelper::clean($subtitle) !!}</h4>
                            @endif

                            <h3 @class(['tpexclusive__title', 'mb-30' => $loop->first, 'mb-10' => $loop->index === 1])>{!! BaseHelper::clean($ad->name) !!}</h3>

                            @if($subtitle && $loop->index === 1)
                                <p>{!! BaseHelper::clean($subtitle) !!}</p>
                            @endif
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
