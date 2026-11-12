@php
    use Botble\Ecommerce\Models\ProductSpecificationAttributeTranslation;

    $currentLangCode = ProductSpecificationAttributeTranslation::getCurrentLanguageCode();

    $visibleAttributes = $product->getVisibleSpecificationAttributes();
@endphp

<div class="product-specification-table">
    <div class="row">
        @foreach($visibleAttributes as $index => $attribute)
            <div class="col-md-6">
                <div class="spec-item">
                    <span class="spec-label">{{ $attribute->name }}</span>
                    <span class="spec-value">
                        @if ($attribute->type == 'checkbox')
                            @if ($attribute->pivot->value)
                                <span class="spec-badge spec-badge-success">
                                    <x-core::icon name="ti ti-check" />
                                    {{ __('Yes') }}
                                </span>
                            @else
                                <span class="spec-badge spec-badge-danger">
                                    <x-core::icon name="ti ti-x" />
                                    {{ __('No') }}
                                </span>
                            @endif
                        @else
                            {{ ProductSpecificationAttributeTranslation::getDisplayValue($product, $attribute, $currentLangCode) }}
                        @endif
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</div>
