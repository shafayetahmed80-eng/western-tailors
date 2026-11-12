<?php

use Botble\Base\Facades\MetaBox;
use Botble\Page\Models\Page;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        $pages = Page::query()
            ->whereNotIn('template', ['default', 'blank'])
            ->get();

        foreach ($pages as $page) {
            $headerStyle = match ($page->template) {
                'wooden' => 'collapsed',
                'cosmetics' => 'centered-logo',
                default => 'default',
            };

            $page->update([
                'template' => 'full-width',
            ]);

            MetaBox::saveMetaBoxData($page, 'header_style', $headerStyle);
        }
    }
};
