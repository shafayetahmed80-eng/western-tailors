<?php

use Botble\Widget\AbstractWidget;

class DownloadAppsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Download Apps'),
            'description' => __('Widget display Download apps.'),
            'title' => 'Download App on Mobile',
            'subtitle' => '15% discount on your first purchase',
            'ios_image' => '',
            'ios_link' => '#',
            'android_image' => '',
            'android_link' => '#',
        ]);
    }
}
