<section class="category-area pt-70 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tpsection mb-40">
                    <h2 class="tpsection__title">{!! BaseHelper::clean($shortcode->title) !!}</h2>
                </div>
            </div>
        </div>
        <div class="custom-row category-border pb-45 justify-content-xl-between">
            @foreach($categories as $category)
                <div class="tpcategory mb-40">
                    <a href="{{ $category->url }}">
                        <div class="tpcategory__icon p-relative">
                            @if($icon = $category->icon)
                                <i class="{{ $icon }}"></i>
                            @else
                                <img src="{{ RvMedia::getImageUrl($category->image, default: RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}">
                            @endif
                            <span>{{ number_format($category->products_count) }}</span>
                        </div>
                    </a>
                    <div class="tpcategory__content">
                        <p class="tpcategory__title">
                            <a href="{{ $category->url }}">{{ $category->name }}</a>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
