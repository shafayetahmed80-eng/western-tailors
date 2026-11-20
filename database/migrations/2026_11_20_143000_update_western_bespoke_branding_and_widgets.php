<?php

use Botble\Setting\Models\Setting;
use Botble\Widget\Models\Widget;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class () extends Migration {
    public function up(): void
    {
        // 1. Update Theme Options & Brand Settings in `settings` table
        $brandingSettings = [
            'theme-ninico-site_title' => 'Western Bespoke | Master Tailors & Luxury Atelier',
            'theme-ninico-seo_description' => 'Western Bespoke — Master Tailors & Sartorial Atelier. Handcrafted bespoke suits, tuxedos, blazers, and custom formalwear in Bangladesh. Book private fittings & consultations.',
            'theme-ninico-primary_color' => '#0A192F',
            'theme-ninico-primary_font' => 'Jost',
            'theme-ninico-heading_font' => 'Playfair Display',
            'theme-ninico-accent_gold_color' => '#C5A880',
            'theme-ninico-header_menu_text_hover_color' => '#C5A880',
            'theme-ninico-cart_footer_description' => 'Complimentary bespoke fitting & alterations with every bespoke order',
            'theme-ninico-footer_bottom_background_color' => '#F4F4F2',
            'theme-ninico-social_links' => json_encode([
                [
                    ['key' => 'name', 'value' => 'Facebook'],
                    ['key' => 'icon', 'value' => 'ti ti-brand-facebook'],
                    ['key' => 'url', 'value' => 'https://www.facebook.com/westernbespoke'],
                ],
                [
                    ['key' => 'name', 'value' => 'Instagram'],
                    ['key' => 'icon', 'value' => 'ti ti-brand-instagram'],
                    ['key' => 'url', 'value' => 'https://www.instagram.com/westernbespoke'],
                ],
                [
                    ['key' => 'name', 'value' => 'WhatsApp'],
                    ['key' => 'icon', 'value' => 'ti ti-brand-whatsapp'],
                    ['key' => 'url', 'value' => 'https://wa.me/8801700000000'],
                ],
            ]),
        ];

        foreach ($brandingSettings as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now()]
            );
        }

        // 2. Update Footer Widgets
        // 2a. Update SiteInfoWidget (Replace pink origami text with Western Bespoke Atelier story)
        $siteInfoWidget = Widget::query()
            ->where('widget_id', 'SiteInfoWidget')
            ->where('theme', 'ninico')
            ->first();

        if ($siteInfoWidget) {
            $data = $siteInfoWidget->data;
            if (is_string($data)) {
                $data = json_decode($data, true) ?: [];
            }
            $data['description'] = 'Western Bespoke Atelier stands for uncompromising craft, master anatomical precision, and world-class imported fabrics. Tailoring bespoke suits, tuxedos, and blazers for the distinguished gentleman.';
            $siteInfoWidget->data = $data;
            $siteInfoWidget->save();
        }

        // 2b. Update SiteCopyrightWidget
        $copyrightWidget = Widget::query()
            ->where('widget_id', 'SiteCopyrightWidget')
            ->where('theme', 'ninico')
            ->first();

        if ($copyrightWidget) {
            $data = $copyrightWidget->data;
            if (is_string($data)) {
                $data = json_decode($data, true) ?: [];
            }
            $data['description'] = 'Copyright ' . date('Y') . ' © Western Bespoke. Handcrafted for Gentlemen. All rights reserved.';
            $copyrightWidget->data = $data;
            $copyrightWidget->save();
        }

        // 2c. Remove DownloadAppsWidget (Eliminate mock app store download buttons)
        Widget::query()
            ->where('widget_id', 'DownloadAppsWidget')
            ->where('theme', 'ninico')
            ->delete();

        // 3. Clean up Navigation Menus
        // 3a. Remove dummy template sub-items from Home in Main Menu
        DB::table('menu_nodes')
            ->where('menu_id', 1)
            ->whereIn('title', [
                'Wooden Home',
                'Fashion Home',
                'Furniture Home',
                'Cosmetics Home',
                'Food Grocery',
                'Shop Grid',
                'Shop List',
                'Shop Detail',
            ])
            ->delete();

        // Ensure "Home" is a direct link without redundant dropdown
        DB::table('menu_nodes')
            ->where('menu_id', 1)
            ->where('title', 'Home')
            ->update([
                'has_child' => 0,
                'url' => '/',
            ]);

        // Rename "Shop" to "Bespoke Collections"
        DB::table('menu_nodes')
            ->where('menu_id', 1)
            ->where('title', 'Shop')
            ->update([
                'title' => 'Bespoke Collections',
                'url' => '/products',
            ]);

        // 3b. Clean up Social Menu (Menu 4)
        DB::table('menu_nodes')
            ->where('menu_id', 4)
            ->whereIn('title', ['Dribble', 'Behance'])
            ->delete();

        DB::table('menu_nodes')
            ->where('menu_id', 4)
            ->where('title', 'Facebook')
            ->update(['url' => 'https://www.facebook.com/westernbespoke']);

        Log::info('Applied Western Bespoke luxury branding, typography settings, and clean navigation menus.');
    }

    public function down(): void
    {
        // Safe no-op on rollback
    }
};
