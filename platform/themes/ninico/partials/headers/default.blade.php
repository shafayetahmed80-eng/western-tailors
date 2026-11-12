<header class="main-header">
    {!! Theme::partial('header-top') !!}
    <div class="main-menu-area d-none d-xl-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <div class="main-menu d-flex align-items-center">
                        {!! Theme::partial('logo') !!}
                        <div class="mainmenu__main d-flex align-items-center p-relative">
                            <div class="main-menu">
                                <nav id="mobile-menu">
                                    {!! Menu::renderMenuLocation('main-menu', ['view' => 'menu']) !!}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                @if (is_plugin_active('ecommerce'))
                    <div class="col-xl-3 col-lg-3">
                        <div class="header-meta d-flex align-items-center justify-content-end">
                            <div class="mainmenu__search w-100">
                                <form action="{{ route('public.products') }}" class="position-relative form--quick-search" data-url="{{ route('public.ajax.search-products') }}" method="GET">
                                    <div class="mainmenu__search-bar p-relative">
                                        <button class="mainmenu__search-icon" title="search"><i class="fal fa-search"></i></button>
                                        <input type="text" name="q" class="input-search-product" placeholder="{{ __('Search products...') }}" value="{{ BaseHelper::stringify(request()->query('q')) }}" autocomplete="off">
                                    </div>
                                    <div class="panel--search-result"></div>
                                </form>
                            </div>
                            {!! Theme::partial('header-meta') !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>

{!! Theme::partial('navbar') !!}
