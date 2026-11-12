<div class="col-lg-2 col-md-4 col-sm-6">
    <div class="footer-widget footer-col-2 ml-30 mb-40">
        <h4 class="footer-widget__title mb-30">{!! BaseHelper::clean(Arr::get($config, 'name')) !!}</h4>
        <div class="footer-widget__links">
            {!! Menu::generateMenu(['slug' => Arr::get($config, 'menu_id'), 'view' => 'footer-menu']) !!}
        </div>
    </div>
</div>

