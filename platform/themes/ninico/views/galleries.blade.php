@php
    Theme::asset()->remove('gallery-css');
    Theme::asset()->container('footer')->remove('imagesloaded');
@endphp

<section class="pt-50 pb-100">
    <div class="container">
        <div class="page-content">
            <article class="post post--single">
                <div class="post__content">
                    @if (isset($galleries) && !$galleries->isEmpty())
                        <div id="list-photo" class="row justify-content-center">
                            @foreach ($galleries as $gallery)
                                <div class="col-12 col-md-4 col-lg-3 mb-4 text-center">
                                    <a href="{{ $gallery->url }}">
                                        <img src="{{ RvMedia::getImageUrl($gallery->image) }}" style="max-width: 100%; border-radius: 0.3rem" alt="{{ $gallery->name }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </article>
        </div>
    </div>
</section>
