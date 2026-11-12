<section class="contact-area mb-40">
    <div class="row">
        <div class="col-lg-4 col-12">
            <div class="tpcontact__right mb-40">
                <div class="tpcontact__shop mb-30">
                    <h4 class="tpshop__title mb-25">{!! BaseHelper::clean($shortcode->title) !!}</h4>
                    <div class="tpshop__info">
                        <ul>
                            @if($address = $shortcode->address)
                                <li>
                                    <i class="fal fa-map-marker-alt"></i>
                                    <a href="https://maps.google.com/maps?q={{ addslashes($address) }}" target="_blank">{{ $address }}</a>
                                </li>
                            @endif
                            @if($phone = $shortcode->phone)
                                <li>
                                    <i class="fal fa-phone-alt"></i>
                                    <a href="tel:{{ $phone }}">{{ $phone }}</a>
                                </li>
                            @endif
                            @if($email = $shortcode->email)
                                <li>
                                    <i class="fal fa-envelope"></i>
                                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                                </li>
                            @endif
                            @if($hours = $shortcode->hours)
                                <li>
                                    <i class="fal fa-clock"></i>
                                    <span>{{ __('Store Hours:') }}</span>
                                    <span>{{ $hours }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="tpcontact__support">
                    @foreach(range(1, 2) as $i)
                        @if($label = $shortcode->{'button_label_' . $i})
                            <a href="{{ $shortcode->{'button_url_' . $i} }}">
                                {{ $label }}
                                @if($icon = $shortcode->{'button_icon_' . $i})
                                    {!! BaseHelper::renderIcon($icon) !!}
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-12">
            <div class="tpcontact__form">
                <div class="tpcontact__info mb-35">
                    <h4 class="tpcontact__title">{!! BaseHelper::clean($shortcode->form_title) ?: __('Make Custom Request') !!}</h4>

                    <p>{!! BaseHelper::clean($shortcode->form_subtitle) ?: __('Must-have pieces selected every month want style Ideas and Treats?') !!}</p>
                </div>
                {!! $form->renderForm() !!}
            </div>
        </div>
    </div>
</section>
