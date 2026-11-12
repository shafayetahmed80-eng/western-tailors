@php
    $itemsPerRow ??= get_products_per_row();

    $itemsPerRowOnMobile = theme_option('ecommerce_products_per_row_mobile', 2);
@endphp

<div class="row row-cols-xxl-{{ $itemsPerRow }} row-cols-lg-{{ $itemsPerRow - 1 }} row-cols-md-{{ $itemsPerRow - 2 }} row-cols-sm-{{ $itemsPerRowOnMobile }} row-cols-{{ $itemsPerRowOnMobile }}">
    @foreach($products as $product)
        <div class="col">
            @include(Theme::getThemeNamespace('views.ecommerce.includes.product-item'))
        </div>
    @endforeach
</div>

@if (theme_option('enable_quick_view', 'yes') === 'yes')
    @include(Theme::getThemeNamespace('views.ecommerce.includes.quick-view-modal'))
@endif
