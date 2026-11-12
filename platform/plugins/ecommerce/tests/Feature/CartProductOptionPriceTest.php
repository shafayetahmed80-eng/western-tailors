<?php

namespace Botble\Ecommerce\Tests\Feature;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Supports\BaseTestCase;
use Botble\Ecommerce\Facades\Cart;
use Botble\Ecommerce\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartProductOptionPriceTest extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Cart::instance('cart')->destroy();
    }

    protected function tearDown(): void
    {
        Cart::instance('cart')->destroy();

        parent::tearDown();
    }

    protected function makeProductOptionData(float $affectPrice, int $affectType = 0, string $optionType = 'select'): array
    {
        return [
            'optionCartValue' => [
                1 => [
                    [
                        'option_value' => 'Size XL',
                        'affect_price' => $affectPrice,
                        'affect_type' => $affectType,
                        'option_type' => $optionType,
                    ],
                ],
            ],
            'optionInfo' => [
                1 => 'Size',
            ],
        ];
    }

    protected function makeMultiOptionData(array $options): array
    {
        $optionCartValue = [];
        $optionInfo = [];

        foreach ($options as $index => $option) {
            $key = $index + 1;
            $optionCartValue[$key] = [
                [
                    'option_value' => $option['value'],
                    'affect_price' => $option['affect_price'],
                    'affect_type' => $option['affect_type'] ?? 0,
                    'option_type' => $option['option_type'] ?? 'select',
                ],
            ];
            $optionInfo[$key] = $option['name'];
        }

        return [
            'optionCartValue' => $optionCartValue,
            'optionInfo' => $optionInfo,
        ];
    }

    public function test_positional_add_includes_option_price(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'price' => 10.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $productOptions = $this->makeProductOptionData(5.00);

        $cartItem = Cart::instance('cart')->add(
            $product->id,
            $product->name,
            1,
            10.00,
            [
                'options' => $productOptions,
                'taxRate' => 0,
            ]
        );

        $this->assertEquals(15.00, $cartItem->price);
        $this->assertEquals(15.00, Cart::instance('cart')->rawSubTotal());
    }

    public function test_array_add_includes_option_price(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'price' => 10.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $productOptions = $this->makeProductOptionData(5.00);

        $cartItem = Cart::instance('cart')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => 10.00,
            'options' => [
                'options' => $productOptions,
                'taxRate' => 0,
            ],
        ]);

        $this->assertEquals(15.00, $cartItem->price);
        $this->assertEquals(15.00, Cart::instance('cart')->rawSubTotal());
    }

    public function test_array_add_with_multiple_quantity_calculates_correct_subtotal(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'price' => 10.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $productOptions = $this->makeProductOptionData(5.00);

        $cartItem = Cart::instance('cart')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 3,
            'price' => 10.00,
            'options' => [
                'options' => $productOptions,
                'taxRate' => 0,
            ],
        ]);

        $this->assertEquals(15.00, $cartItem->price);
        $this->assertEquals(45.00, Cart::instance('cart')->rawSubTotal());
    }

    public function test_positional_add_with_multiple_quantity_calculates_correct_subtotal(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'price' => 20.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $productOptions = $this->makeProductOptionData(8.00);

        $cartItem = Cart::instance('cart')->add(
            $product->id,
            $product->name,
            4,
            20.00,
            [
                'options' => $productOptions,
                'taxRate' => 0,
            ]
        );

        $this->assertEquals(28.00, $cartItem->price);
        $this->assertEquals(112.00, Cart::instance('cart')->rawSubTotal());
    }

    public function test_array_add_applies_percentage_based_option_price(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'price' => 100.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $productOptions = $this->makeProductOptionData(10, 1);

        $cartItem = Cart::instance('cart')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => 100.00,
            'options' => [
                'options' => $productOptions,
                'taxRate' => 0,
            ],
        ]);

        $this->assertEquals(110.00, $cartItem->price);
    }

    public function test_positional_add_applies_percentage_based_option_price(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'price' => 200.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $productOptions = $this->makeProductOptionData(25, 1);

        $cartItem = Cart::instance('cart')->add(
            $product->id,
            $product->name,
            1,
            200.00,
            [
                'options' => $productOptions,
                'taxRate' => 0,
            ]
        );

        $this->assertEquals(250.00, $cartItem->price);
    }

    public function test_array_add_applies_multiple_options(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'price' => 50.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $productOptions = $this->makeMultiOptionData([
            ['name' => 'Size', 'value' => 'XL', 'affect_price' => 5.00],
            ['name' => 'Color', 'value' => 'Gold', 'affect_price' => 3.00],
        ]);

        $cartItem = Cart::instance('cart')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => 50.00,
            'options' => [
                'options' => $productOptions,
                'taxRate' => 0,
            ],
        ]);

        $this->assertEquals(58.00, $cartItem->price);
    }

    public function test_array_add_applies_mixed_fixed_and_percentage_options(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'price' => 100.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $productOptions = $this->makeMultiOptionData([
            ['name' => 'Size', 'value' => 'XL', 'affect_price' => 10.00, 'affect_type' => 0],
            ['name' => 'Finish', 'value' => 'Premium', 'affect_price' => 20, 'affect_type' => 1],
        ]);

        $cartItem = Cart::instance('cart')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => 100.00,
            'options' => [
                'options' => $productOptions,
                'taxRate' => 0,
            ],
        ]);

        // 100 + 10 (fixed) + 20 (20% of 100) = 130
        $this->assertEquals(130.00, $cartItem->price);
    }

    public function test_array_add_sets_correct_tax_rate(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'price' => 100.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $cartItem = Cart::instance('cart')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => 100.00,
            'options' => [
                'taxRate' => 20,
            ],
        ]);

        $this->assertEquals(20, $cartItem->getTaxRate());
    }

    public function test_positional_add_sets_correct_tax_rate(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'price' => 100.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $cartItem = Cart::instance('cart')->add(
            $product->id,
            $product->name,
            1,
            100.00,
            [
                'taxRate' => 15,
            ]
        );

        $this->assertEquals(15, $cartItem->getTaxRate());
    }

    public function test_array_add_without_options_uses_base_price(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'price' => 25.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $cartItem = Cart::instance('cart')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 2,
            'price' => 25.00,
            'options' => [],
        ]);

        $this->assertEquals(25.00, $cartItem->price);
        $this->assertEquals(50.00, Cart::instance('cart')->rawSubTotal());
    }

    public function test_positional_and_array_add_produce_same_price(): void
    {
        $product1 = Product::query()->create([
            'name' => 'Product A',
            'price' => 10.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $product2 = Product::query()->create([
            'name' => 'Product B',
            'price' => 10.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $productOptions = $this->makeProductOptionData(5.00);

        $cartItemPositional = Cart::instance('cart')->add(
            $product1->id,
            $product1->name,
            1,
            10.00,
            [
                'options' => $productOptions,
                'taxRate' => 10,
            ]
        );

        $cartItemArray = Cart::instance('cart')->add([
            'id' => $product2->id,
            'name' => $product2->name,
            'qty' => 1,
            'price' => 10.00,
            'options' => [
                'options' => $productOptions,
                'taxRate' => 10,
            ],
        ]);

        $this->assertEquals($cartItemPositional->price, $cartItemArray->price);
        $this->assertEquals($cartItemPositional->getTaxRate(), $cartItemArray->getTaxRate());
    }

    public function test_positional_and_array_add_produce_same_price_with_multiple_options(): void
    {
        $product1 = Product::query()->create([
            'name' => 'Product A',
            'price' => 50.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $product2 = Product::query()->create([
            'name' => 'Product B',
            'price' => 50.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $productOptions = $this->makeMultiOptionData([
            ['name' => 'Size', 'value' => 'XL', 'affect_price' => 5.00],
            ['name' => 'Color', 'value' => 'Gold', 'affect_price' => 3.00],
        ]);

        $cartItemPositional = Cart::instance('cart')->add(
            $product1->id,
            $product1->name,
            2,
            50.00,
            [
                'options' => $productOptions,
                'taxRate' => 0,
            ]
        );

        $cartItemArray = Cart::instance('cart')->add([
            'id' => $product2->id,
            'name' => $product2->name,
            'qty' => 2,
            'price' => 50.00,
            'options' => [
                'options' => $productOptions,
                'taxRate' => 0,
            ],
        ]);

        $this->assertEquals(58.00, $cartItemPositional->price);
        $this->assertEquals($cartItemPositional->price, $cartItemArray->price);
    }

    public function test_refresh_preserves_option_prices(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'price' => 10.00,
            'status' => BaseStatusEnum::PUBLISHED,
            'is_variation' => false,
            'quantity' => 100,
            'with_storehouse_management' => false,
        ]);

        $productOptions = $this->makeProductOptionData(5.00);

        Cart::instance('cart')->add(
            $product->id,
            $product->name,
            2,
            10.00,
            [
                'image' => 'test.jpg',
                'options' => $productOptions,
                'taxRate' => 0,
            ]
        );

        $this->assertEquals(30.00, Cart::instance('cart')->rawSubTotal());

        Cart::instance('cart')->refresh();

        $refreshedItem = Cart::instance('cart')->content()->first();

        $this->assertNotNull($refreshedItem);
        $this->assertEquals(15.00, $refreshedItem->price);
        $this->assertEquals(30.00, Cart::instance('cart')->rawSubTotal());
    }

    public function test_option_price_preserved_in_cart_content(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'price' => 10.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $productOptions = $this->makeProductOptionData(5.00);

        Cart::instance('cart')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => 10.00,
            'options' => [
                'options' => $productOptions,
                'taxRate' => 0,
            ],
        ]);

        $content = Cart::instance('cart')->content();
        $this->assertCount(1, $content);

        $item = $content->first();
        $this->assertEquals(15.00, $item->price);
        $this->assertEquals(1, $item->qty);
    }

    public function test_option_with_zero_affect_price_does_not_change_price(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'price' => 10.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $productOptions = $this->makeProductOptionData(0);

        $cartItem = Cart::instance('cart')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => 10.00,
            'options' => [
                'options' => $productOptions,
                'taxRate' => 0,
            ],
        ]);

        $this->assertEquals(10.00, $cartItem->price);
    }

    public function test_multiple_items_with_different_options_in_cart(): void
    {
        $product1 = Product::query()->create([
            'name' => 'Product A',
            'price' => 10.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $product2 = Product::query()->create([
            'name' => 'Product B',
            'price' => 20.00,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $options1 = $this->makeProductOptionData(5.00);
        $options2 = $this->makeProductOptionData(8.00);

        Cart::instance('cart')->add([
            'id' => $product1->id,
            'name' => $product1->name,
            'qty' => 1,
            'price' => 10.00,
            'options' => [
                'options' => $options1,
                'taxRate' => 0,
            ],
        ]);

        Cart::instance('cart')->add([
            'id' => $product2->id,
            'name' => $product2->name,
            'qty' => 2,
            'price' => 20.00,
            'options' => [
                'options' => $options2,
                'taxRate' => 0,
            ],
        ]);

        // Product A: 10 + 5 = 15, qty 1 = 15
        // Product B: 20 + 8 = 28, qty 2 = 56
        // Total: 15 + 56 = 71
        $this->assertEquals(71.00, Cart::instance('cart')->rawSubTotal());
    }

    public function test_get_price_by_options_with_fixed_price(): void
    {
        $options = [
            'optionCartValue' => [
                1 => [
                    ['option_value' => 'XL', 'affect_price' => 5.00, 'affect_type' => 0, 'option_type' => 'select'],
                ],
            ],
        ];

        $result = Cart::instance('cart')->getPriceByOptions(10.00, $options);

        $this->assertEquals(15.00, $result);
    }

    public function test_get_price_by_options_with_percentage_price(): void
    {
        $options = [
            'optionCartValue' => [
                1 => [
                    ['option_value' => 'Premium', 'affect_price' => 20, 'affect_type' => 1, 'option_type' => 'select'],
                ],
            ],
        ];

        $result = Cart::instance('cart')->getPriceByOptions(100.00, $options);

        $this->assertEquals(120.00, $result);
    }

    public function test_get_price_by_options_with_multiple_values(): void
    {
        $options = [
            'optionCartValue' => [
                1 => [
                    ['option_value' => 'XL', 'affect_price' => 5.00, 'affect_type' => 0, 'option_type' => 'select'],
                ],
                2 => [
                    ['option_value' => 'Gold', 'affect_price' => 3.00, 'affect_type' => 0, 'option_type' => 'select'],
                ],
            ],
        ];

        $result = Cart::instance('cart')->getPriceByOptions(10.00, $options);

        $this->assertEquals(18.00, $result);
    }

    public function test_get_price_by_options_skips_field_type(): void
    {
        $options = [
            'optionCartValue' => [
                1 => [
                    ['option_value' => 'Custom text', 'affect_price' => 0, 'affect_type' => 0, 'option_type' => 'field'],
                ],
            ],
        ];

        $result = Cart::instance('cart')->getPriceByOptions(10.00, $options);

        $this->assertEquals(10.00, $result);
    }

    public function test_get_price_by_options_with_empty_options(): void
    {
        $result = Cart::instance('cart')->getPriceByOptions(10.00, []);

        $this->assertEquals(10.00, $result);
    }

    public function test_get_price_by_options_with_empty_option_cart_value(): void
    {
        $options = ['optionCartValue' => []];

        $result = Cart::instance('cart')->getPriceByOptions(10.00, $options);

        $this->assertEquals(10.00, $result);
    }
}
