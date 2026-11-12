<ul {!! $options !!}>
    @foreach ($menu_nodes->loadMissing('metadata') as $key => $node)
        <li @class([$node->css_class => $node->css_class])>
            <a
                href="{{ url($node->url) }}"
                title="{{ $node->title }}"
                @if ($node->target !== '_self') target="{{ $node->target }}" @endif
            >
                {!! $node->icon_html !!}

                {{ $node->title }}
            </a>
        </li>
    @endforeach
</ul>
