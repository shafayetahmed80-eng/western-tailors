@php($galleries = get_galleries(isset($shortcode) && (int) $shortcode->limit ? (int) $shortcode->limit : ($limit ?: 6)))

@if (! $galleries->isEmpty())
    <section class="shop-area pb-100">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="tpsectionarea text-center mb-35">
                        @if($subtitle = $shortcode->subtitle)
                            <h5 class="tpsectionarea__subtitle">{!! BaseHelper::clean($subtitle) !!}</h5>
                        @endif
                        @if($title = $shortcode->title)
                            <h4 class="tpsectionarea__title">
                                {!! BaseHelper::clean($title) !!}
                            </h4>
                        @endif
                    </div>
                </div>
            </div>
            <div class="shopareaitem">
                <div class="shopslider-active swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($galleries as $gallery)
                            <div class="tpshopitem swiper-slide">
                                @if($image = RvMedia::getImageUrl($gallery->image, 'medium'))
                                    <a href="{{ $gallery->url }}">
                                        <img src="{{ $image }}" alt="{{ $gallery->name }}">
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
