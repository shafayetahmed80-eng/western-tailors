@php
    $crumbs = Theme::breadcrumb()->getCrumbs();
    $pageTitle = Theme::get('pageTitle') !== null ? Theme::get('pageTitle') : ($crumbs ? Arr::get(Arr::last($crumbs), 'label') : SeoHelper::getTitle());
    $breadcrumbBannerImage = Theme::get('breadcrumbBannerImage') ?: RvMedia::getImageUrl(theme_option('breadcrumb_background'));
@endphp

<section class="breadcrumb__area pt-60 pb-60 tp-breadcrumb__bg"
         @if($breadcrumbBannerImage)
             data-background="{{ $breadcrumbBannerImage }}"
         @else
             style="background-color: {{ theme_option('breadcrumb_background_color', '#F8F8F8') }}"
    @endif
>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="tp-breadcrumb">
                    @if($crumbs)
                        <div @class(['tp-breadcrumb__link', 'mb-10' => $pageTitle])>
                            @foreach($crumbs as $crumb)
                                <span @class(['breadcrumb-item-active' => ! $loop->last])>
                                    @if(! $loop->last)
                                        <a href="{{ $crumb['url'] }}">{!! BaseHelper::clean($crumb['label']) !!}</a>
                                    @else
                                        {!! BaseHelper::clean($crumb['label']) !!}
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    @endif
                    @if($pageTitle)
                        <h2 class="tp-breadcrumb__title">{{ $pageTitle }}</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
