@php
    Theme::set('pageTitle', __('Track Your Order'));
@endphp

<div class="track-area container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="tptrack__product">
                @if ($background = theme_option('order_tracking_background'))
                    <div class="tptrack__thumb">
                        {{ RvMedia::image(theme_option('order_tracking_background'), __('Order Tracking')) }}
                    </div>
                @endif
                <div class="tptrack__content grey-bg-3">
                    <div class="tptrack__item d-flex mb-20">
                        <div class="tptrack__item-icon">
                            <img src="{{ Theme::asset()->url('img/icons/track-1.png') }}" alt="{{ __('Order Tracking') }}">
                        </div>
                        <div class="tptrack__item-content">
                            <h4 class="tptrack__item-title">{{ __('Track Your Order') }}</h4>
                            <p>{{ __('To track your order please enter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have received.') }}</p>
                        </div>
                    </div>
                    <form method="get" action="{{ route('public.orders.tracking') }}">
                        <div class="tptrack__id mb-10">
                            <div>
                                <span><i class="fal fa-address-card"></i></span>
                                <input type="text" name="order_id" placeholder="{{ __('Order ID') }}" value="{{ old('order_id', BaseHelper::stringify(request()->input('order_id'))) }}">
                            </div>
                        </div>

                        @error('order_id')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror

                        <div class="tptrack__email mb-10">
                            <div>
                                <span><i class="fal fa-envelope"></i></span>
                                <input type="email" name="email" placeholder="{{ __('Email address') }}" value="{{ old('email', BaseHelper::stringify(request()->input('email'))) }}">
                            </div>
                        </div>
                        @error('email')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror

                        <div class="tptrack__btn">
                            <button class="tptrack__submition">
                                {{ __('Track Now') }}
                                <i class="fal fa-long-arrow-right"></i>
                            </button>
                        </div>
                    </form>

                    @if ($order)
                        <div class="mt-40">
                            @include('plugins/ecommerce::themes.includes.order-tracking-detail')
                        </div>
                    @elseif (request()->filled(['order_id', 'email']))
                        <p class="text-center text-danger mt-40">{{ __('Order not found!') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
