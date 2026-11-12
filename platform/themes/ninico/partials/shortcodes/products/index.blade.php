<section class="product-area pt-30 pb-30">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="tpsection mb-40">
                    <h2 class="tpsection__title">{!! BaseHelper::clean($shortcode->title) !!}</h2>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="tpnavbar mb-40">
                    <nav>
                        <div class="nav nav-tabs" id="product-type-tab" role="tablist" data-route="{{ route('public.ajax.products') }}" data-limit="{{ $shortcode->limit }}">
                            @foreach($tabs as $key => $value)
                                @continue(! in_array($key, $selectedTabs) || (! EcommerceHelper::isReviewEnabled() && $key === 'top-rated'))

                                <button @class(['nav-link', 'active' => $loop->first]) data-type="{{ $key }}" id="nav-{{ $key }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ $key }}" type="button" role="tab" aria-controls="nav-{{ $key }}-tab" @if($loop->first) aria-selected="true" @endif>
                                    {{ $value }}
                                </button>
                            @endforeach
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="tab-content position-relative" id="nav-tabContent">
            <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="nav-all-tab"></div>
            <div class="loading-spinner"></div>
        </div>
    </div>
</section>
