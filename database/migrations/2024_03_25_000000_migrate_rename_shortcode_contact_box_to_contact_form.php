<?php

use Botble\Page\Models\Page;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        Page::query()->each(function (Page $page) {
            $content = $page->content;

            if (str_contains($content, '[contact-box')) {
                $content = str_replace('[contact-box', '[contact-form', $content);
                $content = str_replace('[/contact-box]', '[/contact-form]', $content);

                $page->content = $content;
                $page->saveQuietly();
            }
        });
    }
};
