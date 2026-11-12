<div class="form-group">
    <label class="form-label" for="widget-icon">{{ __('Icon') }}</label>
    {!! Form::themeIcon('icon', Arr::get($config, 'icon')) !!}
</div>

<div class="form-group">
    <label class="form-label" for="widget-phone">{{ __('Phone number') }}</label>
    <input type="text" id="widget-phone" class="form-control" name="phone" value="{{ Arr::get($config, 'phone') }}">
</div>

<div class="form-group">
    <label class="form-label" for="widget-text">{{ __('Text') }}</label>
    <input type="text" id="widget-text" class="form-control" name="text" value="{{ Arr::get($config, 'text') }}">
</div>
