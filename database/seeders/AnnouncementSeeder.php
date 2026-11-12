<?php

namespace Database\Seeders;

use ArchiElite\Announcement\Enums\TextAlignment;
use ArchiElite\Announcement\Models\Announcement;
use Botble\Base\Supports\BaseSeeder;
use Botble\Setting\Facades\Setting;
use Carbon\Carbon;

class AnnouncementSeeder extends BaseSeeder
{
    public function run(): void
    {
        Announcement::query()->truncate();

        $announcements = [
            'Welcome to our international shop! Enjoy free shipping on orders $100 & up',
            'Trendy 25 silver jewelry, save up 35% off today',
            'Black Friday and Cyber Monday 2023 Deals for Motion Designers, grab it now!',
        ];

        $now = Carbon::now();

        foreach ($announcements as $key => $value) {
            Announcement::query()->create([
                'name' => sprintf('Announcement %s', $key + 1),
                'content' => sprintf('<strong>%s</strong>', $value),
                'has_action' => true,
                'action_label' => 'Shop now',
                'action_url' => '/',
                'start_date' => $now,
                'dismissible' => true,
            ]);
        }

        $settings = [
            'announcement_text_alignment' => TextAlignment::START,
            'announcement_background_color' => '#f3eee7',
            'announcement_text_color' => '#000000',
            'announcement_font_size' => 13,
            'announcement_font_size_unit' => 'px',
            'announcement_autoplay' => true,
            'announcement_autoplay_delay' => 5000,
        ];

        Setting::delete(array_keys($settings));

        Setting::set($settings)->save();
    }
}
