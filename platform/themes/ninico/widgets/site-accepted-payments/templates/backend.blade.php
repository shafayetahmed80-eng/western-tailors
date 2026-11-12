<div class="mb-3">
    <label class="form-label">{{ __('Image') }}</label>
    {{ Form::mediaImage('image', $config['image']) }}
</div>

<div class="mb-3">
    <label class="form-label">{{ __('URL (optional)') }}</label>
    <input type="text" class="form-control" name="url" value="{{ $config['url'] }}">
</div>
