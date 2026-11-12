<div class="form-group">
    <label>{{ __('Title') }}</label>
    <input type="text" class="form-control" name="title" value="{{ Arr::get($config, 'title') }}">
</div>

<div class="form-group">
    <label>{{ __('Subtitle') }}</label>
    <input type="text" class="form-control" name="subtitle" value="{{ Arr::get($config, 'subtitle') }}">
</div>

<div class="form-group">
    <label>{{ __('iOS link') }}</label>
    <input type="text" class="form-control" name="ios_link" value="{{ Arr::get($config, 'ios_link') }}">
</div>

<div class="form-group">
    <label>{{ __('iOS image') }}</label>
    {!! Form::mediaImage('ios_image', Arr::get($config, 'ios_image')) !!}
</div>

<div class="form-group">
    <label>{{ __('Android link') }}</label>
    <input type="text" class="form-control" name="android_link" value="{{ Arr::get($config, 'android_link') }}">
</div>

<div class="form-group">
    <label>{{ __('Android image') }}</label>
    {!! Form::mediaImage('android_image', Arr::get($config, 'android_image')) !!}
</div>
