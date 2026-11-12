@php
    $categoriesRequest ??= [];
    $activeCategoryId ??= 0;

    if (!isset($groupedCategories)) {
        $groupedCategories = $categories->groupBy('parent_id');
    }

    $currentCategories = $groupedCategories->get($parentId ?? 0);
@endphp

@if($currentCategories)
    <div class="product-sidebar__list" @if (in_array($activeCategoryId, $categoriesRequest) || isset($category) && $categoryId == $category->id) style="display: block !important;" @endif>
        @foreach ($currentCategories as $category)
            <div class="category-filter">
                @php
                    $hasChildren = $groupedCategories->has($category->id);
                @endphp

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" @checked(in_array($category->id, $categoriesRequest)) id="category-filter-{{ $category->id }}">
                    <label class="form-check-label" for="category-filter-{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                    @if ($hasChildren)
                        <button class="f-right"><i class="far fa-angle-down"></i></button>
                    @endif
                </div>

                @if ($hasChildren)
                    @include(Theme::getThemeNamespace('views.ecommerce.includes.categories'), [
                        'categories' => $groupedCategories,
                        'parentId' => $category->id,
                    ])
                @endif
            </div>
        @endforeach
    </div>
@endif
