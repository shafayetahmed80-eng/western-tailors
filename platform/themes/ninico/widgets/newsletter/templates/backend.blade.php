<div class="form-group">
    <label class="form-label" for="widget-title">{{ __('Title') }}</label>
    <input type="text" id="widget-title" class="form-control" name="title" value="{{ Arr::get($config, 'tittle') }}">
</div>

<div class="form-group">
    <label class="form-label" for="widget-subtitle">{{ __('Subtitle') }}</label>
    <textarea name="subtitle" id="widget-subtitle" class="form-control" rows="4">{{ Arr::get($config, 'subtitle') }}</textarea>
</div>
