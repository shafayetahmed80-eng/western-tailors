<div class="form-group">
    <label class="form-label" for="widget-description">{{ __('Description') }}</label>
    <textarea name="description" id="widget-description" class="form-control" rows="3">{{ Arr::get($config, 'description') }}</textarea>
</div>
