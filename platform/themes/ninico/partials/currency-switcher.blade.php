@if (is_plugin_active('ecommerce'))
    @php
        $mobile ??= false;
    @endphp

    @if (isset($currencies) && count($currencies) > 1)
        @if($mobile)
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-usd-circle"></i>
                    {{ get_application_currency()->title }}
                </a>
                <ul class="dropdown-menu">
                    @foreach($currencies as $currency)
                        <li>
                            <a class="dropdown-item" href="{{ route('public.change-currency', $currency->title) }}">{{ $currency->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
            <div class="headertoplag__lang">
                <ul>
                    <li>
                        <button>
                            {{ get_application_currency()->title }}
                            <span><i class="fal fa-angle-down"></i></span>
                        </button>
                        <ul class="header-meta__lang-submenu">
                            @foreach($currencies as $currency)
                                <li>
                                    <a href="{{ route('public.change-currency', $currency->title) }}">{{ $currency->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        @endif
    @endif
@endif
