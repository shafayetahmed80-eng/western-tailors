@if(is_plugin_active('language'))
    @php
        $locales = Language::getSupportedLocales();
        $languageDisplay = setting('language_display', 'all');
        $showFlag = $languageDisplay === 'all' || $languageDisplay === 'flag';
        $showName = $languageDisplay === 'all' || $languageDisplay === 'name';
        $mobile ??= false;
    @endphp

    @if($locales && count($locales) > 1)
        @if($mobile)
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="me-2">
                        {!! language_flag(Language::getCurrentLocaleFlag(), Language::getCurrentLocaleName(), 20) !!}
                    </span>
                    {{ Language::getCurrentLocaleName() }}
                </a>
                <ul class="dropdown-menu">
                    @foreach($locales as $key => $locale)
                        @continue($key === Language::getCurrentLocale())

                        <li>
                            <a class="dropdown-item" href="{{ Language::getLocalizedURL($key) }}">
                                @if($showFlag)
                                    {!! language_flag($locale['lang_flag'], $locale['lang_name']) !!}
                                @endif
                                @if($showName)
                                    {{ $locale['lang_name'] }}
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
            <div class="headertoplag__lang">
                <ul>
                    <li>
                        <button>
                            {!! language_flag(Language::getCurrentLocaleFlag(), Language::getCurrentLocaleName()) !!}
                            {{ Language::getCurrentLocaleName() }}
                            <span><i class="fal fa-angle-down"></i></span>
                        </button>
                        <ul class="header-meta__lang-submenu">
                            @foreach($locales as $key => $locale)
                                @continue($key === Language::getCurrentLocale())

                                <li>
                                    <a href="{{ Language::getLocalizedURL($key) }}">
                                        @if($showFlag)
                                            {!! language_flag($locale['lang_flag'], $locale['lang_name']) !!}
                                        @endif
                                        @if($showName)
                                            {{ $locale['lang_name'] }}
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        @endif
    @endif
@endif
