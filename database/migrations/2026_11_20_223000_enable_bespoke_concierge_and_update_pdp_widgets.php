<?php

use Botble\Widget\Models\Widget;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class () extends Migration {
    public function up(): void
    {
        // 1. Configure WhatsApp Concierge Theme Settings
        $conciergeSettings = [
            'theme-ninico-whatsapp_number' => '+8801700000000',
            'theme-ninico-whatsapp_concierge_enabled' => 'yes',
        ];

        foreach ($conciergeSettings as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now()]
            );
        }

        // 2. Update Product Detail Sidebar SiteFeaturesWidget with Bespoke Guarantees
        $featuresWidget = Widget::query()
            ->where('widget_id', 'SiteFeaturesWidget')
            ->where('theme', 'ninico')
            ->first();

        if ($featuresWidget) {
            $data = $featuresWidget->data;
            if (is_string($data)) {
                $data = json_decode($data, true) ?: [];
            }

            $data['title'] = 'Bespoke Atelier Guarantees';
            $data['data'] = [
                '1' => [
                    'icon' => 'icons/verified.png',
                    'text' => '100% Handcrafted Floating Canvas',
                ],
                '2' => [
                    'icon' => 'icons/support.png',
                    'text' => 'Direct Master Tailor WhatsApp Concierge',
                ],
                '3' => [
                    'icon' => 'icons/fast-delivery.png',
                    'text' => 'Private Atelier & Home Fitting Service',
                ],
                '4' => [
                    'icon' => 'icons/cash-on-delivery.png',
                    'text' => 'Complimentary Lifetime Alteration Guarantee',
                ],
            ];

            $featuresWidget->data = $data;
            $featuresWidget->save();
            Log::info('SiteFeaturesWidget successfully updated with Bespoke Atelier Guarantees.');
        }
    }

    public function down(): void
    {
        // Revert back to default
        $featuresWidget = Widget::query()
            ->where('widget_id', 'SiteFeaturesWidget')
            ->where('theme', 'ninico')
            ->first();

        if ($featuresWidget) {
            $data = $featuresWidget->data;
            if (is_string($data)) {
                $data = json_decode($data, true) ?: [];
            }

            $data['title'] = 'Site Features';
            $data['data'] = [
                '1' => ['icon' => 'icons/verified.png', 'text' => '100% Original Products'],
                '2' => ['icon' => 'icons/fast-delivery.png', 'text' => 'Fast Delivery within 24-72 Hours'],
                '3' => ['icon' => 'icons/cash-on-delivery.png', 'text' => 'Cash On Delivery Available'],
                '4' => ['icon' => 'icons/support.png', 'text' => '24/7 Order Support via whatsapp'],
            ];

            $featuresWidget->data = $data;
            $featuresWidget->save();
        }
    }
};
