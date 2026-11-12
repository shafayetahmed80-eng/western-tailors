<div class="form-group">
    <label class="form-label" for="widget-name">{{ __('Name') }}</label>
    <input type="text" id="widget-name" class="form-control" name="name" value="{{ $config['name'] }}">
</div>

<div style="max-height: 400px; overflow: auto" class="border mb-2">
    @foreach(range(1, 5) as $i)
        <div class="bg-light p-1">
            <div class="form-group mb-3">
                <label>{{ __('Text :number', ['number' => $i]) }}</label>
                <textarea name="data[{{ $i }}][text]" class="form-control" rows="2">{{ Arr::get(Arr::get($config['data'], $i), 'text') }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label>{{ __('Icon :number', ['number' => $i]) }}</label>
                {!! Form::mediaImage('data[' . $i . '][icon]', Arr::get(Arr::get($config['data'], $i), 'icon')) !!}
            </div>
        </div>
    @endforeach
</div>
