<ul {!! $options !!}>
    @foreach ($menu_nodes as $key => $node)
        @php($hasMegaMenu = $node->has_child && count($node->child) > 12)
        <li @class([
                $node->css_class => $node->css_class,
                'has-dropdown' => $node->has_child,
                'has-megamenu' => $hasMegaMenu
            ])>
            <a href="{{ url($node->url) }}" @if ($node->target !== '_self') target="{{ $node->target }}" @endif @class(['mega-menu-title' => $hasMegaMenu])>
                {!! $node->icon_html !!}

                {{ $node->title }}
            </a>

            @if ($node->has_child)
                @if ($hasMegaMenu)
                    {!! Menu::generateMenu([
                       'menu' => $node,
                       'menu_nodes' => $node->child,
                       'view' => 'mega-menu',
                       'options' => ['class' => 'submenu mega-menu'],
                   ]) !!}
                @else
                    {!! Menu::generateMenu([
                        'menu' => $node,
                        'menu_nodes' => $node->child,
                        'view' => 'menu',
                        'options' => ['class' => 'submenu'],
                    ]) !!}
                @endif
            @endif
        </li>
    @endforeach
</ul>
