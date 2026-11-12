@include('plugins/ecommerce::themes.includes.product-price', [
    'product' => $product,
    'priceClassName' => $priceClassName ?? 'product-price-sale',
    'priceOriginalClassName' => $priceOriginalClassName ?? 'product-price-original',
])
