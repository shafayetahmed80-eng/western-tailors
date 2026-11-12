@php
    $key = mt_rand();
    $referenceProduct ??= null;
@endphp

<div
    class="product-attributes product-attribute-swatches"
    id="product-attributes-{{ $product->id }}"
    data-target="{{ route('public.web.get-variation-by-attributes', $product->id) }}"
>
    @php
         $variationInfo = $productVariationsInfo;
         $variationNextIds = [];
    @endphp

    @foreach($attributeSets as $set)
        @if (! $loop->first)
            @php
                $variationInfo = $productVariationsInfo->where('attribute_set_id', $set->id)->whereIn('variation_id', $variationNextIds);
            @endphp
        @endif

        @if (View::exists(Theme::getThemeNamespace("views.ecommerce.attributes._layouts.{$set->display_layout}")))
            @include(Theme::getThemeNamespace("views.ecommerce.attributes._layouts.{$set->display_layout}"), compact('selected', 'referenceProduct'))
        @else
            @include(Theme::getThemeNamespace('views.ecommerce.attributes._layouts.dropdown'), compact('selected', 'referenceProduct'))
        @endif

        @php
            [$variationNextIds] = handle_next_attributes_in_product(
                $attributes->where('attribute_set_id', $set->id),
                $productVariationsInfo,
                $set->id,
                $selected->pluck('id')->toArray(),
                $loop->index,
                $variationNextIds);
        @endphp
    @endforeach
</div>
