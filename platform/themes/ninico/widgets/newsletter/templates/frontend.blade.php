@if (is_plugin_active('newsletter'))
    <div class="col-lg-3 col-md-4">
        <div class="footer-widget footer-col-5 mb-40">
            @if($title = Arr::get($config, 'title'))
                <h4 class="footer-widget__title mb-30">{!! BaseHelper::clean($title) !!}</h4>
            @endif
            @if($subtitle = Arr::get($config, 'subtitle'))
                <p>{!! BaseHelper::clean($subtitle) !!}</p>
            @endif
            <div class="footer-widget__newsletter">
                {!! $form->renderForm() !!}
            </div>
        </div>
    </div>
@endif
