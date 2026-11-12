@if ($paginator->hasPages())
    <div class="basic-pagination">
        <nav>
            <ul>
                @if ($paginator->onFirstPage())
                    <li>
                        <span>
                            <i class="fal fa-long-arrow-left"></i>
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}">
                            <i class="fal fa-long-arrow-left"></i>
                        </a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li>
                            <span>{{ $element }}</span>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li>
                                    <span class="current">{{ $page }}</span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}">
                            <i class="fal fa-long-arrow-right"></i>
                        </a>
                    </li>
                @else
                    <li>
                        <span>
                            <i class="fal fa-long-arrow-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
