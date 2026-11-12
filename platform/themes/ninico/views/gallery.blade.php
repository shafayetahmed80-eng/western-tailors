@php
    Theme::asset()->remove('gallery-css');
    Theme::asset()->container('footer')->remove('imagesloaded');
@endphp

<section class="pt-50 pb-100">
    <div class="container">
        <div class="page-content">
            <article class="post post--single">
                <div class="post__content">
<div class="ck-content">
            {!! BaseHelper::clean($gallery->description) !!}
        </div>
                    <div id="list-photo" class="row justify-content-center">
                        @foreach (gallery_meta_data($gallery) as $image)
                            @if ($image)
                                <div class="col-12 col-md-4 col-lg-3 mb-4 text-center" data-src="{{ RvMedia::getImageUrl(Arr::get($image, 'img')) }}" data-sub-html="{{ BaseHelper::clean(Arr::get($image, 'description')) }}">
                                    <a href="{{ BaseHelper::clean(Arr::get($image, 'description')) }}">
                                        <img src="{{ RvMedia::getImageUrl(Arr::get($image, 'img')) }}" style="max-width: 100%; border-radius: 0.3rem" alt="{{ BaseHelper::clean(Arr::get($image, 'description')) }}">
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <br>
                    {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, null, $gallery) !!}
                </div>
            </article>
        </div>
    </div>
</section>
