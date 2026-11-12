<div class="tpproduct-details__nab pr-30 mb-40 product-gallery product-gallery-{{ theme_option('ecommerce_product_gallery_image_style', 'vertical') }}">
    <div class="product-gallery__wrapper">
        @foreach ($productImages as $image)
            <a href="{{ RvMedia::getImageUrl($image) }}">
                {{ RvMedia::image($image, $product->name, 'medium') }}
            </a>
        @endforeach
    </div>
    <div class="product-thumbnails" data-vertical="{{ theme_option('ecommerce_product_gallery_image_style', 'vertical') == 'vertical' ? 1 : 0 }}">
        @foreach ($productImages as $image)
            {{ RvMedia::image($image, $product->name, 'thumb') }}
        @endforeach
    </div>
</div>
