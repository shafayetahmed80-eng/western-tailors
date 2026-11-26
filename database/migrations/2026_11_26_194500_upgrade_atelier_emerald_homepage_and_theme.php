<?php

use Botble\Page\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        // 1. Apply Deep Emerald, Travertine & Antique Brass Palette + Editorial Typography
        if (Schema::hasTable('settings')) {
            $atelierSettings = [
                'theme-ninico-primary_color' => '#0B1C18',
                'theme-ninico-accent_gold_color' => '#C6A364',
                'theme-ninico-primary_font' => 'Montserrat',
                'theme-ninico-heading_font' => 'Cormorant Garamond',
                'theme-ninico-header_background_color' => '#0B1C18',
                'theme-ninico-header_text_color' => '#F2EFE9',
                'theme-ninico-header_menu_text_color' => '#F2EFE9',
                'theme-ninico-header_menu_text_hover_color' => '#C6A364',
                'theme-ninico-footer_background_color' => '#06110E',
                'theme-ninico-footer_bottom_background_color' => '#06110E',
                'theme-ninico-footer_text_color' => '#F2EFE9',
                'theme-ninico-footer_text_muted_color' => '#A8A39A',
                'theme-ninico-footer_border_color' => '#2A3833',
                'theme-ninico-newsletter_popup_enable' => '0',
            ];

            foreach ($atelierSettings as $key => $value) {
                DB::table('settings')->updateOrInsert(
                    ['key' => $key],
                    ['value' => $value, 'updated_at' => now()]
                );
            }
        }

        // 2. Upgrade Homepage (Page 1) & Clear Legacy Header Override
        if (Schema::hasTable('pages')) {
            $homeId = 1;
            if (Schema::hasTable('settings')) {
                $configuredHomeId = (int) DB::table('settings')
                    ->where('key', 'theme-ninico-homepage_id')
                    ->value('value');
                if ($configuredHomeId > 0) {
                    $homeId = $configuredHomeId;
                }
            }

            $homePage = Page::query()->find($homeId);
            if ($homePage) {
                $atelierHomeContent = '[atelier-hero][/atelier-hero]'
                    . '[atelier-archive][/atelier-archive]'
                    . '[atelier-craft][/atelier-craft]'
                    . '[atelier-masterpieces per_category="4"][/atelier-masterpieces]'
                    . '[atelier-concierge][/atelier-concierge]';

                $homePage->update([
                    'name' => 'Western Bespoke Atelier',
                    'template' => 'full-width',
                    'content' => $atelierHomeContent,
                ]);

                if (Schema::hasTable('meta_boxes')) {
                    DB::table('meta_boxes')
                        ->where('reference_id', $homeId)
                        ->where('reference_type', Page::class)
                        ->where('meta_key', 'header_style')
                        ->delete();
                }
            }
        }

        // 3. Repair BDT Currency Symbol UTF-8 Encoding if Double-Encoded
        if (Schema::hasTable('ec_currencies')) {
            DB::table('ec_currencies')
                ->where('title', 'BDT')
                ->update(['symbol' => "\u{09F3}"]);
        }

        // 4. Clean Double-Encoded Punctuation in Product & Category Titles
        $mojibakeMap = [
            'â€™' => '’',
            'â€˜' => '‘',
            'â€“' => '–',
            'â€”' => '—',
            "\xC2\xA0" => ' ',
            'Â' => '',
        ];

        foreach (['ec_products', 'ec_product_categories'] as $tbl) {
            if (Schema::hasTable($tbl)) {
                foreach ($mojibakeMap as $bad => $good) {
                    DB::table($tbl)
                        ->where('name', 'like', '%' . $bad . '%')
                        ->update(['name' => DB::raw("REPLACE(`name`, " . DB::getPdo()->quote($bad) . ", " . DB::getPdo()->quote($good) . ")")]);
                }
            }
        }

        // 5. Ensure `contacts.id` has PRIMARY KEY + AUTO_INCREMENT if imported from dump without it
        if (Schema::hasTable('contacts') && in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            try {
                $idCol = DB::selectOne("SHOW COLUMNS FROM `contacts` WHERE Field = 'id'");
                $hasAutoInc = $idCol && str_contains(strtolower((string) ($idCol->Extra ?? '')), 'auto_increment');

                if (! $hasAutoInc) {
                    $hasPrimary = ! empty(DB::select("SHOW INDEX FROM `contacts` WHERE Key_name = 'PRIMARY'"));
                    if (! $hasPrimary) {
                        DB::statement('ALTER TABLE `contacts` ADD PRIMARY KEY (`id`)');
                    }
                    DB::statement('ALTER TABLE `contacts` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
                }
            } catch (\Throwable $e) {
                Log::warning('Skipped contacts auto_increment adjustment: ' . $e->getMessage());
            }
        }

        Log::info('Applied Western Bespoke Atelier Emerald homepage layout, UTF-8 symbol repair, and luxury palette.');
    }

    public function down(): void
    {
        // Safe no-op on rollback
    }
};
