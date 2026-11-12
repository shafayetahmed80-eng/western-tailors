@php
    $groupedCategories = $categories->groupBy('parent_id');

    $currentCategories = $groupedCategories->get(0);
@endphp

@if($currentCategories)
    @foreach ($currentCategories as $category)
        @php
            $hasChildren = $groupedCategories->has($category->id);
        @endphp
        <li @class(['has-dropdown' => $hasChildren])>
            <a href="{{ route('public.single', $category->url) }}">
                @if ($categoryImage = $category->icon_image)
                    <img src="{{ RvMedia::getImageUrl($categoryImage) }}" alt="{{ $category->name }}" class="category-icon me-1">
                @elseif ($categoryIcon = $category->icon)
                    <i class="{{ $categoryIcon }}"></i>
                @endif
                {{ $category->name }}
            </a>
            @if($hasChildren && $currentCategories = $groupedCategories->get($category->id))
                <ul class="submenu">
                    @foreach($currentCategories as $childCategory)
                        <li><a href="{{ route('public.single', $childCategory->url ) }}">{{ $childCategory->name }}</a></li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
@endif
