@php
    $color = $shortcode->text_color;
@endphp

<section @class(['blog-area pt-50 pb-50', 'feature-post-with-sidebar' => $shortcode->style == 'has-sidebar'])
    @if ($bgColor = $shortcode->background_color)
        style="background-color: {{ $bgColor }}"
    @endif
>
    <div class="container">
        <div class="blog-main-box">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="blogheader mb-20 d-flex align-items-center justify-content-between">
                        @if($title = $shortcode->title)
                            <div class="tpsection mb-20">
                                <h2 class="tpsection__title" @if ($color) style="color: {{ $color }}" @endif>{!! BaseHelper::clean($title) !!}</h2>
                            </div>
                        @endif
                        @if ($url = $shortcode->url )
                            <div class="tpallblog mb-20">
                                <h4 class="blog-btn" @if ($color) style="color: {{ $color }}" @endif>
                                    <a href="{{ $url }}">
                                        {{ __('All Blog') }} <i class="far fa-long-arrow-right"></i>
                                    </a>
                                </h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </div>
</section>
