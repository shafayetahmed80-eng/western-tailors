<ul {!! $options !!}>
    @foreach ($menu_nodes as $key => $node)
    @php
        $title = $node->title;
    @endphp

        <li @class([
                $node->css_class => $node->css_class,
                'has-dropdown' => $node->has_child
            ])>
            <a href="{{ url($node->url) }}" @if ($node->target !== '_self') target="{{ $node->target }}" @endif>
                {!! $node->icon_html !!}

                @if ($title)
                    <span class="title">{{ $title }}</span>
                @endif
            </a>

            @if ($node->has_child)
                {!! Menu::generateMenu([
                    'menu' => $node,
                    'menu_nodes' => $node->child,
                    'view' => 'menu',
                    'options' => ['class' => 'submenu'],
                ]) !!}
            @endif
        </li>
    @endforeach
</ul>
