@switch($config['style'])
    @case('style-1')
        <section class="category-area pt-70 pb-70">
            <div class="container">
                <div class="custom-row category-border pb-45 justify-content-xl-between">
                    @foreach($categories as $category)
                        <div class="tpcategory mb-40">
                            <div class="tpcategory__icon p-relative">
                                @if($icon = $category->icon)
                                    <i class="{{ $icon }}"></i>
                                @else
                                    {{ RvMedia::image($category->image, $category->name) }}
                                @endif
                                <span>{{ number_format($category->products_count) }}</span>
                            </div>
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
        @break
    @case('style-2')
        <section class="features-area pt-120 pb-15">
            <div class="container">
                <div class="row fea-row">
                    @foreach($categories as $category)
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="tpfeatures tpfeaturesborder text-center mb-50">
                                <div class="tpfeatures__icon mb-30">
                                    {{ RvMedia::image($category->image, $category->name) }}
                                </div>
                                <div class="tpfeatures__content">
                                    <a href="{{ $category->url }}">
                                        <h5 class="tpfeatures__title">{{ $category->name }}</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @break
@endswitch
