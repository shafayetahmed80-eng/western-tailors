<?php

use ArchiElite\Announcement\Enums\TextAlignment;
use ArchiElite\Announcement\Models\Announcement;
use Botble\PluginManagement\Services\PluginService;
use Botble\Setting\Facades\Setting;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        $headerMessages = theme_option('header_messages');

        if (empty($headerMessages)) {
            return;
        }

        $pluginService = app(PluginService::class);
        $pluginService->activate('announcement');

        $headerMessages = json_decode($headerMessages, true);

        if (empty($headerMessages)) {
            return;
        }

        if (! Schema::hasTable('announcements')) {
            return;
        }

        $now = Carbon::now();

        foreach ($headerMessages as $key => $headerMessage) {
            $headerMessage = collect($headerMessage)->pluck('value', 'key');
            $headerMessages[$key] = [
                'name' => sprintf('Header message %s', $key + 1),
                'content' => sprintf('<strong>%s</strong>', $headerMessage['message']),
                'has_action' => $headerMessage['link'] && $headerMessage['link_text'],
                'action_label' => $headerMessage['link_text'],
                'action_url' => $headerMessage['link'],
                'start_date' => $now,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        Announcement::query()->insert($headerMessages);

        $settings = [
            'announcement_text_alignment' => TextAlignment::START,
            'announcement_background_color' => '#f3eee7',
            'announcement_text_color' => '#000000',
            'announcement_font_size' => 16,
            'announcement_font_size_unit' => 'px',
            'announcement_autoplay' => true,
            'announcement_autoplay_delay' => 3000,
        ];

        Setting::delete(array_keys($settings));

        Setting::set($settings)->save();
    }
};
