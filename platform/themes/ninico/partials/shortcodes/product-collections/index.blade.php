<section class="banner-area pt-15 pb-30">
    <div class="bannerborder">
        <div class="container-fluid">
            <div class="row gx-3">
                @if($collection = $collections->first())
                    <div class="col-lg-4 col-md-12">
                        <a href="{{ route('public.products', ['collections' => [$collection->getKey()]]) }}">
                            <div class="banneritem banneroverlay p-relative">
                                <img src="{{ RvMedia::getImageUrl($collection->image) }}" alt="{{ $collection->name }}">
                            </div>
                        </a>
                    </div>
                @endif
                <div class="col-lg-4 col-md-12">
                    @foreach($collections->slice(1, 2) as $collection)
                        <a href="{{ route('public.products', ['collections' => [$collection->getKey()]]) }}">
                            <div @class(['banneritem banner-animation p-relative', 'mb-15' => $loop->first])>
                                <img src="{{ RvMedia::getImageUrl($collection->image) }}" alt="{{ $collection->name }}">
                            </div>
                        </a>
                    @endforeach
                </div>
                @if($collection = $collections->slice(3)->first())
                    <div class="col-lg-4 col-md-12">
                        <a href="{{ route('public.products', ['collections' => [$collection->getKey()]]) }}">
                            <div class="banneritem banner-animation p-relative">
                                <img src="{{ RvMedia::getImageUrl($collection->image) }}" alt="{{ $collection->name }}">
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
