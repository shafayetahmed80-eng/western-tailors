@php
    $max = ! empty($max) ? $max: 20;
    $current = (int) Arr::get($attributes, 'quantity') ?: 6;
    $selector = 'quantity_' . Str::random(20);
    $choices = collect()->times($max)->mapWithKeys(fn ($i) => [$i => $i]);
@endphp

<div class="form-group">
    <label class="form-label">{{ __('Quantity') }}</label>
    {!! Form::customSelect('quantity', $choices, $current, ['id' => $selector, 'data-max' => $max]) !!}
</div>

<div class="accordion" id="accordion-tab-shortcode mt-2" style="--bs-accordion-btn-padding-y: .7rem;">
    @foreach(range(1, $max) as $i)
        <div @class(['accordion-item' => $i > $current, 'd-none' => ! $i > $current]) data-tab-id="{{ $i }}">
            <h2 class="accordion-header" id="heading-{{ $i }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $i }}" aria-expanded="false" aria-controls="collapse-{{ $i }}">
                    {{ __('Tab :number', ['number' => $i]) }}
                </button>
            </h2>
            <div id="collapse-{{ $i }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $i }}" data-bs-parent="#accordion-tab-shortcode">
                <div class="accordion-body bg-light">
                    <div class="section">
                        @foreach ($fields as $k => $field)
                            @php
                                $key = $k . '_' . $i;
                                $name = $i <= $current ? $key : '';
                            @endphp

                            <div class="form-group">
                                <label @class(['control-label', 'required' => Arr::get($field, 'required')])>{{ Arr::get($field, 'title') }}</label>

                                @switch(Arr::get($field, 'type'))
                                    @case('image')
                                        {!! Form::mediaImage($name, Arr::get($attributes, $key), ['data-name' => $key]) !!}
                                        @break
                                    @case('color')
                                        {!! Form::customColor($name, Arr::get($attributes, $key), ['data-name' => $key]) !!}
                                        @break
                                    @case('icon')
                                        {!! Form::themeIcon($name, Arr::get($attributes, $key), ['data-name' => $key]) !!}
                                        @break
                                    @case('number')
                                        {!! Form::number($name, Arr::get($attributes, $key), [
                                            'class'       => 'form-control',
                                            'placeholder' => Arr::get($field, 'placeholder', Arr::get($field, 'title')),
                                            'data-name'   => $key,
                                        ]) !!}
                                        @break
                                    @case('checkbox')
                                        {!! Form::customSelect($name, ['no' => __('No'), 'yes' => __('Yes')], Arr::get($attributes, $key), ['data-name' => $key]) !!}
                                        @break
                                    @case('textarea')
                                        {!! Form::textarea($name, Arr::get($attributes, $key), [
                                            'class'       => 'form-control',
                                            'placeholder' => Arr::get($field, 'placeholder', Arr::get($field, 'title')),
                                            'data-name'   => $key,
                                        ]) !!}
                                        @break
                                    @default
                                        {!! Form::text($name, Arr::get($attributes, $key), [
                                            'class'       => 'form-control',
                                            'placeholder' => Arr::get($field, 'placeholder', Arr::get($field, 'title')),
                                            'data-name'   => $key,
                                        ]) !!}
                                @endswitch
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
    'use strict';

    $('#{{ $selector }}').on('change', function () {
        var $this = $(this);
        var val = parseInt($this.val()) || 1;

        if (val !== $this.val()) {
            $this.val(val);
        }

        var $section = $this.closest('section');

        for (var index = 1; index <= $this.data('max'); index++) {
            var $el = $section.find('[data-tab-id=' + index + ']');

            if (index <= val) {
                if ($el.hasClass('d-none')) {
                    $el.removeClass('d-none');
                    $el.find('[data-name]').map(function (i, e) {
                        $(e).attr('name', $(e).attr('data-name'));
                    });
                }
            } else {
                $el.addClass('d-none');
                $el.find('[name]').map(function (i, e) {
                    $(e).attr('data-name', $(e).attr('name'));
                    $(e).removeAttr('name');
                });
            }
        }
    });
</script>
