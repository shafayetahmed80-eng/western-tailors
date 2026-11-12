@php
    $tabletImage = $slider->getMetaData('tablet_image', true) ?: $slider->image;
    $mobileImage = $slider->getMetaData('mobile_image', true) ?: $tabletImage;
@endphp
<picture>
    <source
        srcset="{{ RvMedia::getImageUrl($slider->image, null, false, RvMedia::getDefaultImage()) }}"
        media="(min-width: 1200px)"
    />
    <source
        srcset="{{ RvMedia::getImageUrl($tabletImage, null, false, RvMedia::getDefaultImage()) }}"
        media="(min-width: 768px)"
    />
    <source
        srcset="{{ RvMedia::getImageUrl($mobileImage, null, false, RvMedia::getDefaultImage()) }}"
        media="(max-width: 767px)"
    />
    @if ($slider->getMetaData('action_label', true) || ! $slider->link)
        {{ RvMedia::image($slider->image, $slider->title, attributes: ['loading' => 'eager']) }}
    @else
        <a href="{{ $slider->link }}">{{ RvMedia::image($slider->image, $slider->title, attributes: ['loading' => 'eager']) }}</a>
    @endif
</picture>
