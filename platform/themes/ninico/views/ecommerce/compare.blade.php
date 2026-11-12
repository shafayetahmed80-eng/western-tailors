<section
    class="compare-area pt-80 pb-80 wow fadeInUp"
    data-wow-duration=".8s"
    data-wow-delay=".2s"
>
    <div class="container">
        @if (count($products))
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <tbody>
                                <tr>
                                    <th>{{ __('Image') }}</th>
                                    @foreach ($products as $product)
                                        <td>
                                            <img
                                                src="{{ RvMedia::getImageUrl($product->image, 'thumb', false, RvMedia::getDefaultImage()) }}"
                                                alt="{{ $product->name }}"
                                            >
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    @foreach ($products as $product)
                                        <td>
                                            <a
                                                class="product-name"
                                                href="{{ $product->url }}"
                                            >{{ $product->name }}</a>
                                            <a
                                                class="remove-compare-item"
                                                href="#" data-url="{{ route('public.compare.remove', $product->id) }}"
                                            >({{ __('Remove') }})</a>
                                        </td>
                                    @endforeach
                                </tr>
                                @if (EcommerceHelper::isCartEnabled())
                                    <tr>
                                        <th>{{ __('Add to cart') }}</th>
                                        @foreach ($products as $product)
                                            <td>
                                                <a
                                                    class="add-to-cart"
                                                    data-id="{{ $product->id }}"
                                                    href="#" data-url="{{ route('public.cart.add-to-cart') }}"
                                                >
                                                    <i class="fas fa-shopping-bag"></i>
                                                </a>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endif
                                <tr>
                                    <th>{{ __('Description') }}</th>
                                    @foreach ($products as $product)
                                        <td>
                                            {!! BaseHelper::clean($product->description) !!}
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>{{ __('SKU') }}</th>
                                    @foreach ($products as $product)
                                        <td>
                                            {{ $product->sku ? '#' . $product->sku : '' }}
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>{{ __('Availability') }}</th>
                                    @foreach ($products as $product)
                                        <td>
                                            {!! $product->stock_status_html !!}
                                        </td>
                                    @endforeach
                                </tr>
                                @foreach ($attributeSets as $attributeSet)
                                    @if ($attributeSet->is_comparable)
                                        <tr>
                                            <th>{{ $attributeSet->title }}</th>
                                            @foreach ($products as $product)
                                                @php
                                                    $attributes = app(\Botble\Ecommerce\Repositories\Interfaces\ProductInterface::class)->getRelatedProductAttributes($product)->where('attribute_set_id', $attributeSet->id)->sortBy('order');
                                                @endphp
                                                @if ($attributes->isNotEmpty())
                                                    @if ($attributeSet->display_layout === 'dropdown')
                                                        <td>
                                                            {{ $attributes->pluck('title')->implode(', ') }}
                                                        </td>
                                                    @elseif ($attributeSet->display_layout === 'text')
                                                        <td>
                                                            <div class="bb-product-attribute-swatch text-swatches-wrapper attribute-swatches-wrapper">
                                                                <ul class="bb-product-attribute-swatch-list text-swatch attribute-swatch">
                                                                    @foreach ($attributes as $attribute)
                                                                        <li
                                                                            class="bb-product-attribute-swatch-item attribute-swatch-item"
                                                                            data-slug="{{ $attribute->slug }}"
                                                                            data-id="{{ $attribute->id }}"
                                                                        >
                                                                            <label>
                                                                                <input
                                                                                    type="radio"
                                                                                    value="{{ $attribute->id }}"
                                                                                    class="product-filter-item"
                                                                                    disabled
                                                                                >
                                                                                <span class="bb-product-attribute-text-display" style="cursor: default;">{{ $attribute->title }}</span>
                                                                            </label>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <div class="attribute-values">
                                                                <ul class="visual-swatch color-swatch attribute-swatch">
                                                                    @foreach ($attributes as $attribute)
                                                                        <li
                                                                            class="attribute-swatch-item"
                                                                            style="display: inline-block"
                                                                        >
                                                                            <div class="custom-radio">
                                                                                <label>
                                                                                    <input
                                                                                        class="form-control product-filter-item"
                                                                                        type="radio"
                                                                                        disabled
                                                                                    >
                                                                                    <span
                                                                                        style="{{ $attribute->image ? 'background-image: url(' . RvMedia::getImageUrl($attribute->image) . ');' : 'background-color: ' . $attribute->color . ';' }}; cursor: default;"
                                                                                    ></span>
                                                                                </label>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    @endif
                                                @else
                                                    <td>&mdash;</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <p class="text-center text-muted">{{ __('No products in compare list!') }}</p>
        @endif
    </div>
</section>
