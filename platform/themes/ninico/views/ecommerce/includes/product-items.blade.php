@if($products->isNotEmpty())
    @php($currentLayout = $currentLayout ?? get_current_product_layout())

    @include(Theme::getThemeNamespace("views.ecommerce.includes.product-$currentLayout"))

    @if($products instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
        <div class="row mt-50">
            <div class="col-xxl-12 text-center pb-50">
                {{ $products->links(Theme::getThemeNamespace('partials.pagination')) }}
            </div>
        </div>
    @endif
@else
    <div class="my-5 text-center">
        <p class="text-muted">{{ __('No products found!') }}</p>
    </div>
@endif
