{!! dynamic_sidebar('ecommerce_products_sidebar') !!}

<h1 class="d-none">{{ SeoHelper::getTitleOnly() }}</h1>

<div class="product-area pb-20">
    <div class="container">
        <div class="row @if (theme_option('ecommerce_products_page_layout') === 'right_sidebar') flex-row-reverse @endif">
            <div class="col-lg-2 col-md-12 product-filter-mobile">
                <div class="backdrop"></div>
                <div class="product-filter-mobile__inner">
                    <div class="product-filter-mobile__header d-md-none">
                        <h5>{{ __('Filter Products') }}</h5>
                        <button class="close-product-filter-mobile">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="product-filter-mobile__content">
                        @include(Theme::getThemeNamespace('views.ecommerce.includes.filters'))
                    </div>
                </div>
            </div>
            <div class="col-lg-10 col-md-12">
                <div class="product-sidebar__product-item">
                    @include(EcommerceHelper::viewPath('includes.product-listing-page-description'))

                    <div class="product-filter-content mb-20">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="product-item-count">
                                    <span>{{ __(':total Products found', ['total' => $products->total()]) }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-baseline justify-content-between justify-content-md-end">
                                    <div class="d-md-none">
                                        <button class="product-filter-button">
                                            <i class="fas fa-filter"></i>
                                            {{ __('Filter') }}
                                        </button>
                                    </div>
                                    <div class="tpproductnav tpnavbar product-filter-nav">
                                        <div class="product-navtabs d-flex justify-content-end align-items-center">
                                            <div class="tp-shop-selector">
                                                <select name="per-page">
                                                    @foreach (EcommerceHelper::getShowParams() as $key => $value)
                                                        <option
                                                            value="{{ $key }}"
                                                            @selected(request()->input('per-page') === $key || (int) theme_option('number_of_products_per_page') === $key)
                                                        >{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="tp-shop-selector">
                                                <select name="sort-by">
                                                    @foreach (EcommerceHelper::getSortParams() as $key => $value)
                                                        <option
                                                            value="{{ $key }}"
                                                            @selected(request()->input('sort-by') === $key)
                                                        >{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <nav class="nav nav-tabs">
                                            @foreach (get_product_layouts() as $key => $value)
                                                <button
                                                    data-type="{{ $key }}"
                                                    type="button"
                                                    @class([
                                                        'nav-link',
                                                        'active' => get_current_product_layout() === $key,
                                                    ])
                                                >
                                                    <i class="fal fa-{{ $key === 'list' ? 'list-ul' : 'th' }}"></i>
                                                </button>
                                            @endforeach
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row position-relative">
                        <div class="col-lg-12 product-list bb-product-items-wrapper">
                            @include(Theme::getThemeNamespace('views.ecommerce.includes.product-items'))
                        </div>

                        <div class="loading-spinner d-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
