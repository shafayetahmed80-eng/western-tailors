<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\FlashSale;
use Botble\Ecommerce\Models\Product;
use Illuminate\Support\Facades\DB;

class FlashSaleSeeder extends BaseSeeder
{
    public function run(): void
    {
        FlashSale::query()->truncate();
        DB::table('ec_flash_sale_products')->truncate();

        $flashSale1 = FlashSale::query()->create([
            'name' => 'Winter Sale',
            'end_date' => $this->now()->addMonths(3)->addDays($this->fake()->numberBetween(10, 30))->toDateString(),
        ]);

        $flashSale2 = FlashSale::query()->create([
            'name' => 'Cosmetics Sale',
            'end_date' => $this->now()->addMonths(3)->addDays($this->fake()->numberBetween(10, 30))->toDateString(),
        ]);

        foreach (range(1, 10) as $i) {
            $product = Product::query()
                ->where('id', $i)
                ->where('is_variation', 0)
                ->first();

            if (! $product) {
                continue;
            }

            $price = $product->price;

            if ($product->front_sale_price !== $product->price) {
                $price = $product->front_sale_price;
            }

            $flashSale1->products()->attach([$i => ['price' => $price - ($price * rand(10, 70) / 100), 'quantity' => rand(6, 20), 'sold' => rand(1, 5)]]);
        }

        $flashSale2->products()->attach([1 => ['price' => 100, 'quantity' => 10, 'sold' => 5]]);
    }
}
