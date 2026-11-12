<section class="location-area">
    <div class="row">
        @foreach(range(1, (int) $shortcode->quantity) as $i)
            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                <div class="tpshop__location d-block d-sm-flex align-items-center justify-content-between mb-30">
                    <div class="tpshop__content">
                        <h4 class="tpshop__title mb-15">{{ $shortcode->{'name_' . $i} }}</h4>
                        <div class="tpshop__info">
                            <ul>
                                @if($address = $shortcode->{'address_' . $i})
                                    <li>
                                        <i class="fal fa-map-marker-alt"></i>
                                        <a href="https://maps.google.com/maps?q={{ addslashes($address) }}">{{ $address }}</a>
                                    </li>
                                @endif
                                @if($phone = $shortcode->{'phone_' . $i})
                                    <li>
                                        <i class="fal fa-phone-alt"></i>
                                        <a href="tel:{{ $phone }}">{{ $phone }}</a>
                                    </li>
                                @endif
                                @if($hours = $shortcode->{'hours_' . $i})
                                    <li>
                                        <i class="fal fa-clock"></i>
                                        <span>{{ __('Store Hours:') }}</span>
                                        <span>{{ $hours }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="tpshop__thumb">
                        <img src="{{ RvMedia::getImageUrl($shortcode->{'image_' . $i}, default: RvMedia::getDefaultImage()) }}" alt="shop">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
