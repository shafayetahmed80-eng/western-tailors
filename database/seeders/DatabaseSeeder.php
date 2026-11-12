<?php

namespace Database\Seeders;

use Botble\ACL\Database\Seeders\UserSeeder;
use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Database\Seeders\CurrencySeeder;
use Botble\Ecommerce\Database\Seeders\DiscountSeeder;
use Botble\Ecommerce\Database\Seeders\ProductSpecificationSeeder;
use Botble\Ecommerce\Database\Seeders\ReviewSeeder;
use Botble\Ecommerce\Database\Seeders\ShippingSeeder;
use Botble\Ecommerce\Database\Seeders\TaxSeeder;
use Botble\Language\Database\Seeders\LanguageSeeder;

class DatabaseSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->prepareRun();

        $this->call([
            LanguageSeeder::class,
            UserSeeder::class,
            CurrencySeeder::class,
            SettingSeeder::class,
            BlogSeeder::class,
            PageSeeder::class,
            ThemeOptionSeeder::class,
            SimpleSliderSeeder::class,
            WidgetSeeder::class,
            AdsSeeder::class,
            ShippingSeeder::class,
            BrandSeeder::class,
            ProductCategorySeeder::class,
            ProductAttributeSeeder::class,
            ProductTagSeeder::class,
            ProductCollectionSeeder::class,
            ProductLabelSeeder::class,
            ProductOptionSeeder::class,
            TaxSeeder::class,
            FaqSeeder::class,
            ProductSeeder::class,
            ProductSpecificationSeeder::class,
            CustomerSeeder::class,
            ReviewSeeder::class,
            FlashSaleSeeder::class,
            DiscountSeeder::class,
            MenuSeeder::class,
            GallerySeeder::class,
            TeamSeeder::class,
            TestimonialSeeder::class,
            AnnouncementSeeder::class,
        ]);

        $this->finished();
    }
}
