<div class="col-xl-6 col-lg-4 col-md-4 col-sm-6">
    <div class="footer-cta__contact">
        @if($icon = Arr::get($config, 'icon'))
            <div class="footer-cta__icon">
                <i class="{{ $icon }}"></i>
            </div>
        @endif
        <div class="footer-cta__text">
            @if($phone = Arr::get($config, 'phone'))
                <a href="tel:{{ $phone }}">{{ $phone }}</a>
            @endif
            @if($text = Arr::get($config, 'text'))
                <span>{{ BaseHelper::clean($text) }}</span>
            @endif
        </div>
    </div>
</div>
