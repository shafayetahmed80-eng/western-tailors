@php
    $menus = $menu_nodes->split(3);
@endphp

<ul {!! $options !!}>
    @foreach($menus as $nodes)
        <li>
            <ul>
                @foreach($nodes as $node)
                    <li>
                        <a href="{{ $node->url }}">{{ $node->title }}</a>
                    </li>
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>
