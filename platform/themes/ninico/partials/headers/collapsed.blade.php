<header class="main-header">
    {!! Theme::partial('header-top') !!}
    <div class="logo-area pt-30 d-none d-xl-block">
        {!! Theme::partial('header-middle') !!}
    </div>
    <div class="main-menu-area pt-20 d-none d-xl-block">
        <div class="for-megamenu p-relative">
            <div class="container">
                <div class="row align-items-center">
                    @if(Theme::get('hasCategoriesDropdown', true))
                        <div class="col-xl-2 col-lg-3">
                            {!! Theme::partial('categories-dropdown') !!}
                        </div>
                        <div class="col-xl-7 col-lg-6">
                            <div class="main-menu">
                                <nav id="mobile-menu">
                                    {!! Menu::renderMenuLocation('main-menu', ['view' => 'menu']) !!}
                                </nav>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-9">
                            <div class="main-menu">
                                <nav id="mobile-menu">
                                    {!! Menu::renderMenuLocation('main-menu', ['view' => 'menu']) !!}
                                </nav>
                            </div>
                        </div>
                    @endif

                    @if($hotline = theme_option('hotline'))
                        <div class="col-lg-3">
                            <div class="menu-contact">
                                <ul>
                                    <li>
                                        <div class="menu-contact__item">
                                            <div class="menu-contact__icon">
                                                <i class="fal fa-phone-alt"></i>
                                            </div>
                                            <div class="menu-contact__info">
                                                <a href="tel:{{ $hotline }}">{{ $hotline }}</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>

{!! Theme::partial('navbar') !!}
