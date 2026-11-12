@if($products->isNotEmpty())
    <section class="product-area pt-30 pb-30">
        <div class="container">
            <div class="tpsection mb-40">
                <h2 class="tpsection__title">{!! BaseHelper::clean($shortcode->title) !!}</h2>
            </div>

            @include(Theme::getThemeNamespace('views.ecommerce.includes.product-items'), compact('products'))
        </div>
    </section>
@endif
