<header class="platinam-light">
    {!! Theme::partial('header-top', ['class' => 'platinam-bg platinam-header-top']) !!}
    <div class="mainmenuarea platinam-menuarea pt-30 d-none d-xl-block">
        <div class="container">
            <div class="row align-items-center">
                @if (is_plugin_active('ecommerce'))
                    <div class="col-lg-5">
                        <div class="mainmenu d-flex align-items-center">
                            <div class="mainmenu__search w-100">
                                <form action="{{ route('public.products') }}" class="position-relative form--quick-search" data-url="{{ route('public.ajax.search-products') }}" method="GET">
                                    <div class="mainmenu__search-bar p-relative">
                                        <button class="mainmenu__search-icon" title="search"><i class="fal fa-search"></i></button>
                                        <input type="text" name="q" class="input-search-product" placeholder="{{ __('Search products...') }}" value="{{ BaseHelper::stringify(request()->query('q')) }}" autocomplete="off">
                                    </div>
                                    <div class="panel--search-result"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-lg-2">
                    <div class="mainmenu__main text-center">
                        <div class="main-logo">
                            {!! Theme::partial('logo') !!}
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5">
                    {!! Theme::partial('header-meta', ['class' => 'justify-content-end']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="main-menu-area pt-15 d-none d-xl-block">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="menu-area-4">
                        <div class="main-menu">
                            <nav id="mobile-menu" style="display: block;">
                                {!! Menu::renderMenuLocation('main-menu', ['view' => 'menu']) !!}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

{!! Theme::partial('navbar', ['headerMobileStickyClass' => 'platinam-light']) !!}
