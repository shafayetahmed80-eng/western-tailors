<?php

use Botble\Theme\ThemeOption\Fields\ColorField;
use Botble\Theme\Events\RenderingThemeOptionSettings;

app('events')->listen(RenderingThemeOptionSettings::class, function (): void {
    theme_option()
        ->setSection([
            'title' => __('Styles'),
            'id' => 'opt-text-subsection-styles',
            'subsection' => true,
            'icon' => 'ti ti-palette',
            'fields' => [
                [
                    'id' => 'primary_font',
                    'type' => 'googleFonts',
                    'label' => __('Primary font'),
                    'attributes' => [
                        'name' => 'primary_font',
                        'value' => 'Jost',
                    ],
                ],
                [
                    'id' => 'primary_color',
                    'type' => 'customColor',
                    'label' => __('Primary color'),
                    'attributes' => [
                        'name' => 'primary_color',
                        'value' => '#d51243',
                    ],
                ],
                [
                    'id' => 'header_style',
                    'type' => 'customSelect',
                    'label' => __('Header style'),
                    'attributes' => [
                        'name' => 'header_style',
                        'list' => [
                            'default' => __('Default'),
                            'centered-logo' => __('Centered logo'),
                            'collapsed' => __('Collapsed'),
                        ],
                        'value' => 'default',
                        'options' => [
                            'class' => 'form-control',
                        ],
                    ],
                ],
                [
                    'id' => 'collapsing_product_categories_on_homepage',
                    'type' => 'customSelect',
                    'label' => 'Collapsing product categories on homepage?',
                    'attributes' => [
                        'name' => 'collapsing_product_categories_on_homepage',
                        'list' => [
                            'yes' => trans('core/base::base.yes'),
                            'no' => trans('core/base::base.no'),
                        ],
                        'value' => 'no',
                        'options' => [
                            'class' => 'form-control',
                        ],
                    ],
                ],
                [
                    'id' => 'footer_background_color',
                    'type' => 'customColor',
                    'label' => __('Footer background color'),
                    'attributes' => [
                        'name' => 'footer_background_color',
                        'value' => '#F8F8F8',
                    ],
                ],
                [
                    'id' => 'footer_text_color',
                    'type' => 'customColor',
                    'label' => __('Footer text color'),
                    'attributes' => [
                        'name' => 'footer_text_color',
                        'value' => '#000000',
                    ],
                ],
                [
                    'id' => 'footer_text_muted_color',
                    'type' => 'customColor',
                    'label' => __('Footer text muted color'),
                    'attributes' => [
                        'name' => 'footer_text_muted_color',
                        'value' => '#686666',
                    ],
                ],
                [
                    'id' => 'footer_border_color',
                    'type' => 'customColor',
                    'label' => __('Footer border color'),
                    'attributes' => [
                        'name' => 'footer_border_color',
                        'value' => '#E0E0E0',
                    ],
                ],
                [
                    'id' => 'footer_bottom_background_color',
                    'type' => 'customColor',
                    'label' => __('Footer bottom background color'),
                    'attributes' => [
                        'name' => 'footer_bottom_background_color',
                        'value' => '#ededed',
                    ],
                ],
                ColorField::make()
                    ->name('header_background_color')
                    ->label(__('Header background color'))
                    ->defaultValue('#fff'),
                ColorField::make()
                    ->name('header_text_color')
                    ->label(__('Header text color'))
                    ->defaultValue('#040404'),
                ColorField::make()
                    ->name('header_menu_text_color')
                    ->label(__('Header menu text color'))
                    ->defaultValue('#040404'),
                ColorField::make()
                    ->name('header_menu_text_hover_color')
                    ->label(__('Header menu text hover color'))
                    ->defaultValue('#d51243'),
            ],
        ])
        ->setField([
            'id' => 'sticky_header_enabled',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customSelect',
            'label' => __('Enable sticky header?'),
            'attributes' => [
                'name' => 'sticky_header_enabled',
                'list' => [
                    'yes' => __('Yes'),
                    'no' => __('No'),
                ],
                'value' => 'yes',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'sticky_header_mobile_enabled',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customSelect',
            'label' => __('Enable sticky header on mobile?'),
            'attributes' => [
                'name' => 'sticky_header_mobile_enabled',
                'list' => [
                    'yes' => __('Yes'),
                    'no' => __('No'),
                ],
                'value' => 'yes',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'bottom_mobile_menu_enabled',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customSelect',
            'label' => __('Enable bottom menu on mobile?'),
            'attributes' => [
                'name' => 'bottom_mobile_menu_enabled',
                'list' => [
                    'yes' => __('Yes'),
                    'no' => __('No'),
                ],
                'value' => 'yes',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'bottom_mobile_menu_show_label',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customSelect',
            'label' => __('Show label for bottom menu item on mobile?'),
            'attributes' => [
                'name' => 'bottom_mobile_menu_show_label',
                'list' => [
                    'yes' => __('Yes'),
                    'no' => __('No'),
                ],
                'value' => 'yes',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'hotline',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'text',
            'label' => __('Hotline'),
            'attributes' => [
                'name' => 'hotline',
                'value' => '908. 408. 501. 89',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'cart_footer_description',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type' => 'text',
            'label' => __('Cart footer description'),
            'attributes' => [
                'name' => 'cart_footer_description',
                'value' => 12,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'display_product_categories_select_on_header',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type' => 'customSelect',
            'label' => __('Display product categories select on header?'),
            'attributes' => [
                'name' => 'display_product_categories_select_on_header',
                'list' => [
                    'yes' => __('Yes'),
                    'no' => __('No'),
                ],
                'value' => 'yes',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'display_product_categories_on_mobile_menu',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type' => 'customSelect',
            'label' => __('Display product categories on mobile menu?'),
            'attributes' => [
                'name' => 'display_product_categories_on_mobile_menu',
                'list' => [
                    'yes' => __('Yes'),
                    'no' => __('No'),
                ],
                'value' => 'yes',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'ecommerce_product_gallery_image_style',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type' => 'customSelect',
            'label' => __('Product gallery image style?'),
            'attributes' => [
                'name' => 'ecommerce_product_gallery_image_style',
                'list' => [
                    'vertical' => __('Vertical'),
                    'horizontal' => __('Horizontal'),
                ],
                'value' => 'vertical',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'section_id' => 'opt-text-subsection-breadcrumb',
            'id' => 'breadcrumb_background_color',
            'type' => 'customColor',
            'label' => __('Breadcrumb background color'),
            'attributes' => [
                'name' => 'breadcrumb_background_color',
                'value' => '#F8F8F8',
            ],
        ])
        ->setField([
            'id' => 'breadcrumb_background',
            'section_id' => 'opt-text-subsection-breadcrumb',
            'type' => 'mediaImage',
            'label' => __('Breadcrumb background'),
            'attributes' => [
                'name' => 'breadcrumb_background',
            ],
        ])
        ->setField([
            'id' => '404_not_found_icon',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'mediaImage',
            'label' => __('404 Not found icon'),
            'attributes' => [
                'name' => '404_not_found_icon',
            ],
        ])
        ->setField([
            'id' => 'order_tracking_background',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type' => 'mediaImage',
            'label' => __('Order tracking background'),
            'attributes' => [
                'name' => 'order_tracking_background',
            ],
        ])
        ->setField([
            'id' => 'default_product_list_layout',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type' => 'customSelect',
            'label' => __('Default product items layout'),
            'attributes' => [
                'name' => 'default_product_list_layout',
                'list' => [
                    'list' => __('List'),
                    'grid' => __('Grid'),
                ],
            ],
        ])
        ->setField([
            'id' => 'ecommerce_products_page_layout',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type' => 'customSelect',
            'label' => __('Products listing page layout'),
            'attributes' => [
                'name' => 'ecommerce_products_page_layout',
                'list' => [
                    'left_sidebar' => __('Left sidebar'),
                    'right_sidebar' => __('Right sidebar'),
                ],
            ],
        ])
        ->setField([
            'id' => 'ecommerce_header_categories_limit',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type' => 'text',
            'label' => __('Header sidebar categories limit'),
            'attributes' => [
                'name' => 'ecommerce_header_categories_limit',
                'value' => 10,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'logo_light',
            'section_id' => 'opt-text-subsection-logo',
            'type' => 'mediaImage',
            'label' => __('Logo light'),
            'attributes' => [
                'name' => 'logo_light',
                'value' => null,
            ],
        ])
        ->setField([
            'id' => 'logo_height',
            'section_id' => 'opt-text-subsection-logo',
            'type' => 'number',
            'label' => __('Logo height (px)'),
            'attributes' => [
                'name' => 'logo_height',
                'value' => 35,
                'options' => [
                    'class' => 'form-control',
                    'min' => 0,
                    'max' => 150,
                ],
            ],
            'helper' => __('Set the height of the logo in pixels. The default value is 35px.'),
        ])
        ->setField([
            'id' => 'number_of_products_per_row',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type' => 'customSelect',
            'label' => __('Number of products per row'),
            'attributes' => [
                'name' => 'number_of_products_per_row',
                'list' => [
                    3 => 3,
                    4 => 4,
                    5 => 5,
                    6 => 6,
                ],
                'value' => 5,
                'options' => [
                    'class' => 'form-select',
                ],
            ],
        ])
        ->setField([
            'id' => 'ecommerce_products_per_row_mobile',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type' => 'customSelect',
            'label' => __('Number of products per row on mobile'),
            'attributes' => [
                'name' => 'ecommerce_products_per_row_mobile',
                'list' => [
                    1 => 1,
                    2 => 2,
                ],
                'value' => 2,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'enable_quick_view',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type' => 'customSelect',
            'label' => __('Enable quick view button?'),
            'attributes' => [
                'name' => 'enable_quick_view',
                'list' => [
                    'yes' => __('Yes'),
                    'no' => __('No'),
                ],
                'value' => 'yes',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ]);
});
