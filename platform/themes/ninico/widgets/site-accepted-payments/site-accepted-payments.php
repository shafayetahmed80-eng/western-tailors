<?php

use Botble\Widget\AbstractWidget;

class SiteAcceptedPaymentsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Site Accepted Payments'),
            'description' => __('Display accepted payments image.'),
            'image' => null,
            'url' => null,
        ]);
    }
}
