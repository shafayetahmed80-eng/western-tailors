@php
    $types = [
        '' => __('Latest'),
        'featured' => __('Featured'),
        'popular' => __('Popular'),
        'recent' => __('Recent'),
    ];
@endphp

<div class="form-group">
    <label class="form-label" for="widget-name">{{ __('Name') }}</label>
    <input type="text" class="form-control" name="name" value="{{ Arr::get($config, 'name') }}">
</div>

<div class="form-group">
    <label class="form-label">{{ __('Post type') }}</label>
    {{ Form::customSelect('type', $types, Arr::get($config, 'type')) }}
</div>

<div class="form-group">
    <label class="form-label" for="limit">{{ __('Limit') }}</label>
    <input type="number" class="form-control" name="limit" value="{{ Arr::get($config, 'limit', 4) }}" placeholder="{{ __('Number of posts to display') }}">
</div>
