<?php

use Botble\Base\Forms\FieldOptions\ButtonFieldOption;
use Botble\Newsletter\Forms\Fronts\NewsletterForm;
use Botble\Widget\AbstractWidget;

class NewsletterWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Newsletter form'),
            'description' => __('Display Newsletter form on sidebar'),
            'title' => __('Get Newsletter'),
            'subtitle' => __('Get on the list and get 10% off your first order!'),
        ]);
    }

    public function data(): array
    {
        if (! is_plugin_active('newsletter')) {
            return [];
        }

        $form = NewsletterForm::create()
            ->formClass('newsletter-form')
            ->remove('submit')
            ->add(
                'submit',
                'submit',
                ButtonFieldOption::make()
                    ->label(__('Subscribe Now') . '<i class="fal fa-long-arrow-right"></i>')
                    ->attributes(['class' => 'footer-widget__fw-news-btn tpsecondary-btn'])
                    ->toArray(),
            );

        return compact('form');
    }
}
