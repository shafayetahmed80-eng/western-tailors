<?php

namespace Theme\Ninico\Http\Controllers;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Facades\Cart;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Services\Products\GetProductBySlugService;
use Botble\Ecommerce\Services\Products\GetProductService;
use Botble\Ecommerce\Services\Products\GetProductWithCrossSalesBySlugService;
use Botble\Ecommerce\Services\Products\ProductCrossSalePriceService;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Http\Controllers\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class NinicoController extends PublicController
{
    public function __construct(protected BaseHttpResponse $response)
    {
        $this->middleware(function ($request, $next) {
            if (! $request->ajax()) {
                return $this->response->setNextUrl(BaseHelper::getHomepageUrl());
            }

            return $next($request);
        })->only([
            'ajaxProductShop',
            'ajaxProductView',
            'ajaxAddToWishlist',
            'ajaxCart',
            'ajaxGetProducts',
            'ajaxSearchProducts',
        ]);
    }

    public function ajaxGetProducts(Request $request): BaseHttpResponse
    {
        $limit = $request->integer('limit', 10) ?: 10;

        $params = [
            'take' => $limit,
        ];

        $products = match ($request->query('type')) {
            'featured' => get_featured_products($params),
            'on-sale' => get_products_on_sale($params),
            'trending' => get_trending_products($params),
            'top-rated' => EcommerceHelper::isReviewEnabled() ? get_top_rated_products($limit) : collect(),
            default => get_products($params + EcommerceHelper::withReviewsParams()),
        };

        if (! $products instanceof Collection) {
            $products = collect([$products]);
        }

        $currentLayout = 'grid';

        $data = view(Theme::getThemeNamespace('views.ecommerce.includes.product-items'), compact('products', 'currentLayout'))->render();

        return $this->response->setData($data);
    }

    public function ajaxCart(): BaseHttpResponse
    {
        return $this->response->setData([
            'count' => Cart::instance('cart')->count(),
            'html' => view(Theme::getThemeNamespace('views.ecommerce.includes.mini-cart'))->render(),
        ]);
    }

    /**
     * @deprecated Please view `ajaxProductView` method.
     */
    public function ajaxGetQuickView(string $id): BaseHttpResponse
    {
        $product = get_products(
            [
                'condition' => [
                    'ec_products.id' => $id,
                ],
                'take' => 1,
                'with' => [
                    'slugable',
                    'tags',
                    'tags.slugable',
                    'options',
                    'options.values',
                ],
            ] + EcommerceHelper::withReviewsParams()
        );

        if (! $product) {
            return $this->response
                ->setError()
                ->setMessage(__('This product is not available.'));
        }

        [$productImages, $productVariation, $selectedAttrs] = EcommerceHelper::getProductVariationInfo($product);

        return $this
            ->response
            ->setData(
                view(
                    Theme::getThemeNamespace('views.ecommerce.quick-view'),
                    compact('product', 'productImages', 'productVariation', 'selectedAttrs')
                )->render()
            );
    }

    /**
     * @deprecated Please view `ajaxProductShop` method.
     */
    public function ajaxQuickShop(string $id): BaseHttpResponse
    {
        $product = get_products(
            [
                'condition' => [
                    'ec_products.id' => $id,
                ],
                'take' => 1,
                'with' => [
                    'slugable',
                    'tags',
                    'tags.slugable',
                    'options',
                    'options.values',
                ],
            ] + EcommerceHelper::withReviewsParams()
        );

        if (! $product) {
            return $this->response
                ->setError()
                ->setMessage(__('This product is not available.'));
        }

        [$productImages, $productVariation, $selectedAttrs] = EcommerceHelper::getProductVariationInfo($product);

        return $this
            ->response
            ->setData(
                view(
                    Theme::getThemeNamespace('views.ecommerce.quick-shop'),
                    compact('product', 'productImages', 'productVariation', 'selectedAttrs')
                )->render()
            );
    }

    public function ajaxProductShop(
        GetProductBySlugService $getProductBySlugService,
        GetProductWithCrossSalesBySlugService $getProductWithCrossSalesBySlugService,
        Request $request,
        string $slug
    ) {
        $request->validate([
            'reference_product' => ['sometimes', 'required', 'string'],
        ]);

        $product = $getProductBySlugService->handle($slug, [
            'with' => [
                'slugable',
                'tags',
                'tags.slugable',
                'options',
                'options.values',
            ],
        ]);

        abort_unless($product, 404);

        $referenceProduct = null;

        if (
            $request->filled('reference_product')
            && $referenceProduct = $getProductWithCrossSalesBySlugService->handle(
                $request->input('reference_product')
            )
        ) {
            app(ProductCrossSalePriceService::class)->applyProduct($referenceProduct);
        }

        [$productImages, $productVariation, $selectedAttrs] = EcommerceHelper::getProductVariationInfo($product);

        return $this
            ->response
            ->setData(
                view(
                    Theme::getThemeNamespace('views.ecommerce.quick-shop'),
                    compact('product', 'productImages', 'productVariation', 'selectedAttrs', 'referenceProduct')
                )->render()
            );
    }

    public function ajaxSearchProducts(
        Request $request,
        GetProductService $productService
    ) {
        $request->merge(['num' => 12]);

        $products = $productService->getProduct($request);

        $queries = $request->input();

        foreach ($queries as $key => $query) {
            if (! $query || $key === 'num' || (is_array($query) && ! Arr::get($query, 0))) {
                unset($queries[$key]);
            }
        }

        $total = $products->count();
        $message = $total !== 1 ? __(':total Products found', compact('total')) : __(
            ':total Product found',
            compact('total')
        );

        return $this
            ->response
            ->setData(
                view(
                    Theme::getThemeNamespace('views.ecommerce.includes.ajax-search-results'),
                    compact('products', 'queries')
                )->render()
            )
            ->setMessage($message);
    }
}
