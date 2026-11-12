<?php

use Botble\Theme\Facades\Theme;
use Botble\Widget\Models\Widget;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        Widget::query()
            ->create([
                'widget_id' => 'SiteCopyrightWidget',
                'sidebar_id' => 'footer_bottom_sidebar',
                'position' => 0,
                'data' => [
                    'description' => theme_option('copyright'),
                ],
                'theme' => Theme::getThemeName(),
            ]);
    }
};
