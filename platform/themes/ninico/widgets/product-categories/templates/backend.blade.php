<div class="form-group mb-3">
    <label class="form-label" for="widget-name">{{ trans('core/base::forms.name') }}</label>
    <input type="text" class="form-control" name="name" value="{{ $config['name'] }}">
</div>

<div class="form-group">
    <label class="form-label">{{ __('Style') }}</label>
    {{ Form::customSelect('style', ['style-1' => __('Style 1'), 'style-2' => __('Style 2')], Arr::get($config, 'style')) }}
</div>

@include('plugins/ecommerce::widgets.partials.select-product-categories')
