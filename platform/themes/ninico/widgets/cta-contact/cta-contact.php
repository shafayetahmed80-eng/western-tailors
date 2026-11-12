<?php

use Botble\Widget\AbstractWidget;

class CtaContactWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('CTA contact'),
            'description' => __('Widget call to action contact on footer section.'),
            'icon' => 'far fa-phone-alt',
            'phone' => '980. 029. 666. 99',
            'text' => 'Working 8:00 - 22:00',
        ]);
    }
}
