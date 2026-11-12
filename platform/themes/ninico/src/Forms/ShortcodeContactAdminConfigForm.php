<?php

namespace Theme\Ninico\Forms;

use Botble\Base\Forms\FieldOptions\EmailFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\CoreIconField;
use Botble\Base\Forms\Fields\EmailField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Contact\Forms\ShortcodeContactAdminConfigForm as BaseShortcodeContactAdminConfigForm;

class ShortcodeContactAdminConfigForm extends BaseShortcodeContactAdminConfigForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->add(
                'form_title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Form title'))
                    ->toArray()
            )
            ->add(
                'form_subtitle',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Form subtitle'))
                    ->toArray()
            )
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
                    ->toArray()
            )
            ->add(
                'address',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Address'))
                    ->toArray()
            )
            ->add(
                'phone',
                TextField::class,
                TextFieldOption::make()
                    ->toArray()
            )
            ->add('email', EmailField::class, EmailFieldOption::make()->toArray())
            ->add('hours', TextField::class, TextFieldOption::make()->label(__('Hours'))->toArray());

        for ($i = 1; $i <= 2; $i++) {
            $this
                ->add('button_label_' . $i, TextField::class, [
                    'label' => __('Button label :number', ['number' => $i]),
                ])
                ->add('button_url_' . $i, TextField::class, [
                    'label' => __('Button URL :number', ['number' => $i]),
                ])
                ->add('button_icon_' . $i, CoreIconField::class, [
                    'label' => __('Button icon :number', ['number' => $i]),
                ]);
        }
    }
}
