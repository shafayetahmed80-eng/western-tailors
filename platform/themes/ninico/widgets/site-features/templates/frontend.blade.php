<div class="tpproduct-details__condation">
    <ul>
        @foreach(range(1, 5) as $i)
            @if ($text = Arr::get(Arr::get($config['data'], $i), 'text'))
                <li>
                    <div class="tpproduct-details__condation-item d-flex align-items-center">
                        <div class="tpproduct-details__condation-thumb">
                            <img src="{{ RvMedia::getImageUrl(Arr::get(Arr::get($config['data'], $i), 'icon'), null, false, RvMedia::getDefaultImage()) }}" alt="{{ $text }}" class="tpproduct-details__img-hover" width="34">
                        </div>
                        <div class="tpproduct-details__condation-text">
                            <p>{!! BaseHelper::clean($text) !!}</p>
                        </div>
                    </div>
                </li>
            @endif
        @endforeach
    </ul>
</div>
