<section class="features-area pt-120 pb-15">
    <div class="container">
        <div class="row fea-row">
            @foreach($categories as $category)
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="tpfeatures tpfeaturesborder text-center mb-50">
                        <div class="tpfeatures__icon mb-30">
                            <a href="{{ $category->url }}">
                                <img src="{{ RvMedia::getImageUrl($category->image, default: RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}">
                            </a>
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
