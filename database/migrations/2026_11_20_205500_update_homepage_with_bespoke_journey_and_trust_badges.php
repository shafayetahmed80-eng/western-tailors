<?php

use Botble\Page\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class () extends Migration {
    public function up(): void
    {
        $homePage = Page::query()->find(1);

        if ($homePage) {
            $homePageContent = '[simple-slider key="slider-home-1" style="wooden" ads_1="IYHICPADQD5X" ads_2="R4YAV9FECJUS"][/simple-slider]'
                . '[bespoke-trust-badges][/bespoke-trust-badges]'
                . '[product-categories title="Bespoke <span>Collections</span>" category_ids="1,19,21,24,27,29,32,38,65" style="wooden" enable_lazy_loading="yes"][/product-categories]'
                . '[products style="wooden" title="Master Handcrafted <span>Creations</span>" limit="10" enable_lazy_loading="yes"][/products]'
                . '[bespoke-journey][/bespoke-journey]'
                . '[deal-product flash_sale_id="1" style="wooden" enable_lazy_loading="yes"][/deal-product]'
                . '[gallery title="Western Bespoke Atelier" limit="6" subtitle="Craftsmanship & Detail" enable_lazy_loading="yes"][/gallery]';

            $homePage->update([
                'name' => 'Western Bespoke Atelier',
                'description' => 'Western Bespoke Master Tailors — Handcrafted suits, blazers, and custom formalwear in Bangladesh.',
                'content' => $homePageContent,
            ]);

            Log::info('Homepage (Page 1) updated with Bespoke Journey and Trust Badges shortcodes.');
        }
    }

    public function down(): void
    {
        // Safe no-op
    }
};
